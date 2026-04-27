<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // 🔴 Login Limiter: Protect against brute-force
        RateLimiter::for('login', function (Request $request) {
            $email = $request->input('email');
            
            return [
                // Limit per email: 5 attempts/min
                Limit::perMinute(5)
                    ->by($email . '|' . $request->ip())
                    ->response($this->throttleResponse()),
                
                // Limit per IP: 10 attempts/min
                Limit::perMinute(10)
                    ->by($request->ip())
                    ->response($this->throttleResponse()),
            ];
        });

        // 🟡 Register Limiter: Prevent spam accounts
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response($this->throttleResponse());
        });

        // 🟢 API Limiter: General protection for authenticated routes
        RateLimiter::for('api', function (Request $request) {
            $user = $request->user();
            $key = $user ? $user->id : $request->ip();

            return Limit::perMinute(60)
                ->by($key . '|' . $request->ip())
                ->response($this->throttleResponse());
        });

        // 🔴 Sensitive Limiter: For password updates and critical actions
        RateLimiter::for('sensitive', function (Request $request) {
            $user = $request->user();
            $key = $user ? $user->id : $request->ip();

            return Limit::perMinute(3)
                ->by($key . '|' . $request->ip())
                ->response($this->throttleResponse());
        });
    }

    /**
     * Standard throttle response.
     */
    protected function throttleResponse(): \Closure
    {
        return fn() => response()->json([
            'message' => 'Too many attempts'
        ], 429);
    }
}
