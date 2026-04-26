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
      'access' => 'sometimes|array',
      'access.*.project_id' => 'required_with:access|exists:projects,id',
      'access.*.organization_id' => 'required_with:access|exists:organizations,id',
      'access.*.role_id' => [
        'required_with:access',
        'exists:roles,id',
        function ($attribute, $value, $fail) {
          preg_match('/access\.(\d+)\.role_id/', $attribute, $matches);
          $index = $matches[1];
          $projectId = $this->input("access.{$index}.project_id");

          $role = \App\Modules\Users\Domain\Entities\Role::find($value);

          // Validation: Role must not be 'Root' and must belong to the project (or be global)
          if ($role && ($role->name === 'Root' || ($role->project_id && $role->project_id != $projectId))) {
            $validRoles = \App\Modules\Users\Domain\Entities\Role::where(function ($q) use ($projectId) {
              $q->whereNull('project_id')->orWhere('project_id', $projectId);
            })->where('name', '!=', 'Root')->pluck('name')->implode(', ');

            $fail("El rol seleccionado no es válido. Los roles disponibles para este proyecto son: {$validRoles}.");
          }
        }
      ],
    ];
  }

  public function messages(): array
  {
    return [
      'email.email' => 'El correo electrónico debe ser un correo válido.',
      'email.unique' => 'El correo electrónico ya está registrado.',
      'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
      'access.array' => 'El campo acceso debe ser un arreglo.',
      'access.*.project_id.exists' => 'El proyecto seleccionado no es válido.',
      'access.*.organization_id.exists' => 'La organización seleccionada no es válida.',
      'access.*.role_id.exists' => 'El rol seleccionado no existe.',
    ];
  }
}
