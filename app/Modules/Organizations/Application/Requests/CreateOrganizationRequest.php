<?php

namespace App\Modules\Organizations\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrganizationRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name' => 'required|string|max:255',
    ];
  }

  public function messages(): array
  {
    return [
      'name.required' => 'El nombre de la organización es obligatorio.',
      'name.max' => 'El nombre no puede superar los 255 caracteres.',
    ];
  }
}
