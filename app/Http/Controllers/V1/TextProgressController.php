<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TextProgress\GetTextProgressesRequest;
use App\Http\Requests\TextProgress\SaveProgressRequest;
use App\Http\Resources\TextProgress\ProgressResource;
use App\Http\Resources\TopResult\TopResultResource;
use App\Models\Text;
use App\Models\TextProgress;
use App\Models\TopResult;
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

		$top_result = TopResult::query()->where( 'user_id', $user_id )->first();

		if ( !$text->user_id ) {
			if ( $top_result ) {
				if ( $symbols_per_minute > $top_result->symbols_per_minute ) {
					$top_result->symbols_per_minute = $symbols_per_minute;
					$top_result->save();
				}
			} else {
				TopResult::query()->create( [
					'user_id' => $user_id,
					'symbols_per_minute' => $symbols_per_minute,
				] );
			}
		}

		return response()->json( [
			'success' => true,
		] );
	}

	function getTopRating()
	{
		$top_results = TopResult::query()
			->with( 'user' )
			->orderByDesc( 'symbols_per_minute' )
			->select( '*' )
			->selectRaw( 'ROW_NUMBER() OVER (ORDER BY symbols_per_minute DESC) as position' )
			->paginate( 15 );

		return TopResultResource::collection( $top_results );
	}

	function getCurrentUserBestResult()
	{
		$top_result = TopResult::query()
			->with( 'user' )
			->where( 'user_id', auth()->id() )
			->first();

		if ( !$top_result ) {
			return $this->resultNotFoundResponse();
		}

		$position = TopResult::query()
				->whereNot( 'user_id', auth()->id() )
				->where( 'symbols_per_minute', '>', $top_result->symbols_per_minute )
				->count() + 1;

		$top_result->position = $position;

		return new TopResultResource( $top_result );
	}

	function getTextProgress( GetTextProgressesRequest $request )
	{
		$user_id = auth()->id();
		$text_id = $request->input( 'text_id' );

		$text = Text::query()->find( $text_id );

		if ( !$text ) {
			return $this->textNotFoundResponse();
		}

		$progresses = TextProgress::query()->where( [
			'text_id' => $text_id,
			'user_id' => $user_id,
		] )->orderByDesc( 'created_at' )
			->paginate( 10 );

		return ProgressResource::collection( $progresses );
	}

	protected function textNotFoundResponse() : JsonResponse
	{
		return response()->json( [
			'success' => false,
			'message' => __( 'Text not found' ),
		], 404 );
	}

	protected function resultNotFoundResponse() : JsonResponse
	{
		return response()->json( [
			'success' => false,
			'message' => __( 'Result not found' ),
		], 200 );
	}
}
