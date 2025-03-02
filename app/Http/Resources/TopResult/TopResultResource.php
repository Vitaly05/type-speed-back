<?php

namespace App\Http\Resources\TopResult;

use App\Models\TextProgress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopResultResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray( Request $request ) : array
	{
		$text_progresses = TextProgress::query()->where( 'user_id', $this->user_id );

		return [
			'position' => $this->position,
			'user_name' => $this->user->name,
			'best_spm' => $this->symbols_per_minute,
			'avg_spm' => number_format( $text_progresses->avg( 'symbols_per_minute' ), 2, '.', '' ),
			'text_passed' => $text_progresses->count(),
		];
	}
}
