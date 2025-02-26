<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TextProgress\SaveProgressRequest;
use App\Models\Text;
use App\Models\TextProgress;
use Illuminate\Http\JsonResponse;

class TextProgressController extends Controller
{
	function saveResult( SaveProgressRequest $request )
	{
		$user_id = auth()->id();
		$text_id = $request->input( 'text_id' );
		$mistakes_count = $request->input( 'mistakes_count' );
		$words_per_minute = $request->input( 'words_per_minute' );
		$symbols_per_minute = $request->input( 'symbols_per_minute' );
		$seconds_elapsed = $request->input( 'seconds_elapsed' );

		$text = Text::query()->find( $text_id );

		if ( !$text ) {
			return $this->textNotFoundResponse();
		}

		TextProgress::query()->create( [
			'user_id' => $user_id,
			'text_id' => $text_id,
			'seconds_elapsed' => $seconds_elapsed,
			'mistakes_count' => $mistakes_count,
			'words_per_minute' => $words_per_minute,
			'symbols_per_minute' => $symbols_per_minute,
		] );

		return response()->json( [
			'success' => true,
		] );
	}

	protected function textNotFoundResponse() : JsonResponse
	{
		return response()->json( [
			'success' => false,
			'message' => __( 'Text not found' ),
		], 404 );
	}
}
