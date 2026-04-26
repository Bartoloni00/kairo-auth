<?php

namespace App\Modules\Users\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserToProjectRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'project_id' => 'required|exists:projects,id',
      'role_id' => 'sometimes|exists:roles,id'
    ];
  }
}
