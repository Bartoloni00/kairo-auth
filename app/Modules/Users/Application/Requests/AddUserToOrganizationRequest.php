<?php

namespace App\Modules\Users\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserToOrganizationRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'organization_id' => 'required|exists:organizations,id',
      'role_id' => 'sometimes|exists:roles,id'
    ];
  }
}
