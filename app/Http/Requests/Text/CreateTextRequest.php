<?php

namespace App\Http\Requests\Text;

use App\Traits\CustomValidationResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreateTextRequest extends FormRequest
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
			'title' => 'required|string|max:255',
			'text' => 'required|string|max:65535',
		];
	}
}
