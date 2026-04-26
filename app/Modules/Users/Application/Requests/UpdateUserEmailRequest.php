<?php

namespace App\Modules\Users\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserEmailRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $id = $this->route('id');
    return [
      'email' => 'required|email|unique:users,email,' . $id . ',id,deleted_at,NULL'
    ];
  }
}
