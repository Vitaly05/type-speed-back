<?php

namespace App\Http\Requests\TextProgress;

use App\Traits\CustomValidationResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class SaveProgressRequest extends FormRequest
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
			'text_id' => 'required',
			'mistakes_count' => 'required|integer|min:0|max:4294967295',
			'words_per_minute' => 'required|integer|min:0|max:4294967295',
			'symbols_per_minute' => 'required|integer|min:0|max:4294967295',
			'seconds_elapsed' => 'required|integer|min:0|max:4294967295',
		];
	}
}
