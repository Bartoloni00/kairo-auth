<?php

namespace App\Modules\Users\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'password' => 'required|min:6'
    ];
  }
}
