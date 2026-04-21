<?php

namespace App\Modules\Auth\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'email' => 'required|email',
      'password' => 'required',
    ];
  }

  public function messages(): array
  {
    return [
      'email.required' => 'El correo electrónico es obligatorio.',
      'email.email' => 'El correo electrónico debe ser un correo válido.',
      'password.required' => 'La contraseña es obligatoria.',
    ];
  }

  public function attributes(): array
  {
    return [
      'email' => 'correo electrónico',
      'password' => 'contraseña',
    ];
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getPassword(): string
  {
    return $this->password;
  }
}
