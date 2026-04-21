<?php

namespace App\Modules\Auth\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'email' => 'required|string|email|unique:users,email',
      'password' => 'required|string|min:6',
      'project_id' => 'integer|exists:projects,id',
      'role_id' => 'required_with:project_id|integer|exists:roles,id',
      'organization_id' => 'required_with:project_id|integer|exists:organizations,id',
    ];
  }

  public function messages(): array
  {
    return [
      'email.required' => 'El correo electrónico es obligatorio.',
      'email.email' => 'El correo electrónico debe ser un correo válido.',
      'email.unique' => 'El correo electrónico ya está registrado.',
      'password.required' => 'La contraseña es obligatoria.',
      'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
      'project_id.integer' => 'El proyecto debe ser un número entero.',
      'organization_id.integer' => 'La organización debe ser un número entero.',
      'project_id.exists' => 'El proyecto no existe.',
      'role_id.exists' => 'El rol no existe.',
      'organization_id.exists' => 'La organización no existe.',
    ];
  }

  public function attributes(): array
  {
    return [
      'email' => 'correo electrónico',
      'password' => 'contraseña',
      'project_id' => 'proyecto',
      'role_id' => 'rol',
      'organization_id' => 'organización',
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

  public function getProjectId(): int
  {
    return $this->project_id;
  }

  public function getRoleId(): int
  {
    return $this->role_id;
  }

  public function getOrganizationId(): int
  {
    return $this->organization_id;
  }
}
