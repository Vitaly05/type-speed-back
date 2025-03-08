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
			'texts' => Text::filters()->defaultSort( 'created_at', 'desc' )->paginate( 20 ),
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name() : ?string
	{
		return __( 'Список текстов' );
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar() : iterable
	{
		return [
			ModalToggle::make( __( 'Создать новый' ) )
				->icon( 'bs.plus-lg' )
				->modal( 'editTextModal' )
				->method( 'saveText' )
				->modalTitle( __( 'Создать новый текст' ) ),
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

		Toast::success( __( 'Текст был сохранён' ) )->disableAutoHide();
	}

	public function deleteText( Text $text )
	{
		$text->delete();
		Toast::error( __( 'Текст был удалён' ) )->disableAutoHide();
	}
}
