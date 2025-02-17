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
		$user_progresses = $this->progresses()->where( 'user_id', auth()->id() )->get();

		return [
			'id' => $this->id,
			'title' => $this->title,
			'text' => $this->text,
			'words_count' => $this->words_count,
			'symbols_count' => $this->symbols_count,
			'completed' => [
				'by_user' => $user_progresses->count(),
				'by_others' => $this->progresses()->whereNot( 'user_id', auth()->id() )->count(),
			],
			'record' => [
				'words' => $user_progresses->max( 'words_per_minute' ),
				'symbols' => $user_progresses->max( 'symbols_per_minute' ),
			]
		];
	}
}
