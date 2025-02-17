<?php

namespace App\Orchid\Screens\Text;

use App\Models\Text;
use App\Orchid\Layouts\Text\TextEditLayout;
use App\Orchid\Layouts\Text\TextTableLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TextListScreen extends Screen
{
	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query() : iterable
	{
		return [
			'texts' => Text::filters()->defaultSort( 'created_at' )->paginate( 20 ),
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name() : ?string
	{
		return __( 'Texts list' );
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar() : iterable
	{
		return [
			ModalToggle::make( __( 'Create new' ) )
				->icon( 'bs.plus-lg' )
				->modal( 'editTextModal' )
				->method( 'saveText' )
				->modalTitle( __( 'Create new text' ) ),
		];
	}

	/**
	 * The screen's layout elements.
	 *
	 * @return \Orchid\Screen\Layout[]|string[]
	 */
	public function layout() : iterable
	{
		return [
			Layout::modal( 'editTextModal', TextEditLayout::class )
				->async( 'asyncGetText' ),
			TextTableLayout::class,
		];
	}

	public function asyncGetText( Text $text )
	{
		return [
			'text' => $text,
		];
	}

	public function saveText( Text $text, Request $request )
	{
		$request->validate( [
			'text.title' => 'required|max:255',
			'text.text' => 'required|max:65535',
		] );

		$newData = $request->all()['text'];
		$text->fill( $newData )->save();

		Toast::success( __( 'The text has been saved' ) )->disableAutoHide();
	}

	public function deleteText( Text $text )
	{
		$text->delete();
		Toast::error( __( 'The text has been deleted' ) )->disableAutoHide();
	}
}
