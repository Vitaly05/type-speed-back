<?php

namespace App\Http\Resources\TextProgress;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray( Request $request ) : array
	{
		return [
			'seconds_elapsed' => $this->seconds_elapsed,
			'mistakes_count' => $this->mistakes_count,
			'date' => $this->created_at,
			'speed' => [
				'words' => $this->words_per_minute,
				'symbols' => $this->symbols_per_minute,
			]
		];
	}
}
