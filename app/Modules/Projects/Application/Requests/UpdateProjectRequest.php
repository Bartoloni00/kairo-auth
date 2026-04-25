<?php

namespace App\Modules\Projects\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $id = $this->route('id');
    return [
      'name' => 'sometimes|string|max:255|unique:projects,name,' . $id . ',id,deleted_at,NULL',
      'is_multitenant' => 'boolean',
    ];
  }

  public function messages(): array
  {
    return [
      'name.unique' => 'Ya existe un proyecto con este nombre.',
      'name.max' => 'El nombre no puede superar los 255 caracteres.',
      'is_multitenant.boolean' => 'El campo multitenant debe ser booleano.',
    ];
  }
}
