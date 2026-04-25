<?php

namespace App\Modules\Users\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $id = $this->route('id');
    return [
      'email' => 'sometimes|email|unique:users,email,' . $id . ',id,deleted_at,NULL',
      'password' => 'sometimes|min:6',
    ];
  }

  public function messages(): array
  {
    return [
      'email.email' => 'El correo electrónico debe ser un correo válido.',
      'email.unique' => 'El correo electrónico ya está registrado.',
      'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
    ];
  }
}
