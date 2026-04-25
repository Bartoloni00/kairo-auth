<?php

namespace App\Modules\Organizations\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name' => 'sometimes|string|max:255',
    ];
  }

  public function messages(): array
  {
    return [
      'name.max' => 'El nombre no puede superar los 255 caracteres.',
    ];
  }
}
