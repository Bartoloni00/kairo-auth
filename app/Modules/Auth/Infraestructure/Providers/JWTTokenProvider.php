<?php

namespace App\Modules\Auth\Infraestructure\Providers;

use App\Modules\Auth\Application\Ports\TokenProviderInterface;

class JWTTokenProvider implements TokenProviderInterface
{
  private string $secret;

  public function __construct()
  {
    $this->secret = config('app.jwt.secret');
  }

  public function generate(array $payload): string
  {
    if (!$this->secret) {
      throw new \Exception('JWT secret not configured');
    }

    $header = $this->base64UrlEncode(json_encode([
      'alg' => 'HS256',
      'typ' => 'JWT'
    ], JSON_UNESCAPED_SLASHES));

    $payload['iat'] = time();
    $payload['exp'] = time() + 3600;

    $payloadEncoded = $this->base64UrlEncode(
      json_encode($payload, JSON_UNESCAPED_SLASHES)
    );

    $signature = hash_hmac(
      'sha256',
      "$header.$payloadEncoded",
      $this->secret,
      true
    );

    $signatureEncoded = $this->base64UrlEncode($signature);

    return "$header.$payloadEncoded.$signatureEncoded";
  }

  private function base64UrlEncode(string $data): string
  {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
  }
}
