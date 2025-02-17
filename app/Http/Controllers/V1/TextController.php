<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Text\CreateTextRequest;
use App\Http\Requests\Text\EditTextRequest;
use App\Http\Resources\Text\TextResource;
use App\Models\Text;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TextController extends Controller
{
	public function all()
	{
		$texts = Text::query()
			->whereNull( 'user_id' )
			->orderByDesc( 'created_at' )
			->paginate( 9 );

		return TextResource::collection( $texts );
	}

	public function allWithCurrentUserId()
	{
		$texts = Text::query()
			->where( 'user_id', auth()->user()->id )
			->orderByDesc( 'created_at' )
			->paginate( 9 );

		return TextResource::collection( $texts );
	}

	public function allWithUserId( $user_id )
	{
		$texts = Text::query()
			->where( 'user_id', $user_id )
			->orderByDesc( 'created_at' )
			->paginate( 9 );

		return TextResource::collection( $texts );
	}

	public function create( CreateTextRequest $request )
	{
		$title = trim( $request->input( 'title' ) );
		$text = trim( $request->input( 'text' ) );
		$user_id = auth()->user()->id;

		$text_model = Text::query()->create( [
			'title' => $title,
			'text' => $text,
			'user_id' => $user_id,
		] );

		return new TextResource( $text_model );
	}

	public function edit( $id, EditTextRequest $request )
	{
		$user_id = auth()->user()->id;

		$text_model = Text::query()->find( $id );

		if ( !$text_model || $text_model->user_id !== $user_id ) {
			return $this->textNotFoundResponse();
		}

		$title = trim( $request->input( 'title' ) );
		$text = trim( $request->input( 'text' ) );

		$text_model->update( [
			'title' => $title,
			'text' => $text,
		] );

		return new TextResource( $text_model );
	}

	protected function textNotFoundResponse() : JsonResponse
	{
		return response()->json( [
			'message' => __( 'Text not found' ),
		], 404 );
	}
}
