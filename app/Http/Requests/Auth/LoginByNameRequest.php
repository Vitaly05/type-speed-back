<?php

namespace App\Http\Requests\Auth;

use App\Traits\CustomValidationResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class LoginByNameRequest extends FormRequest
{
	use CustomValidationResponseTrait;

	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize() : bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules() : array
	{
		return [
			'name' => 'required|min:4|max:15',
			'password' => 'required|min:6|max:30',
		];
	}
}
