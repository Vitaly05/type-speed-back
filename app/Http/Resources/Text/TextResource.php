<?php

namespace App\Http\Resources\Text;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TextResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray( Request $request ) : array
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'text' => $this->text,
			'words_count' => $this->words_count,
			'symbols_count' => $this->symbols_count,
		];
	}
}
