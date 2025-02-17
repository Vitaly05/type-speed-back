<?php

namespace App\Orchid\Layouts\Text;

use App\Models\Text;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class TextTableLayout extends Table
{
	/**
	 * Data source.
	 *
	 * The name of the key to fetch it from the query.
	 * The results of which will be elements of the table.
	 *
	 * @var string
	 */
	protected $target = 'texts';

	/**
	 * Get the table cells to be displayed.
	 *
	 * @return TD[]
	 */
	protected function columns() : iterable
	{
		return [
			TD::make( 'id', __( 'ID' ) )
				->sort()
				->filter(),
			TD::make( 'title', __( 'Title' ) )
				->sort()
				->filter(),
			TD::make( 'created_at', __( 'Created' ) )
				->usingComponent( DateTimeSplit::class )
				->sort(),
			TD::make( 'updated_at', __( 'Updated' ) )
				->usingComponent( DateTimeSplit::class )
				->sort(),
			TD::make( 'action', __( 'Action' ) )
				->align( TD::ALIGN_RIGHT )
				->render( function ( Text $text ) {
					return DropDown::make()
						->icon( 'bs.three-dots-vertical' )
						->list( [
							ModalToggle::make( __( 'Edit' ) )
								->icon( 'bs.pencil' )
								->modal( 'editTextModal' )
								->method( 'saveText' )
								->modalTitle( __( 'Edit text' ) )
								->asyncParameters( [
									'text' => $text->id,
								] ),
							Button::make( __( 'Delete' ) )
								->method( 'deleteText', [
									'text' => $text->id,
								] )
								->type( Color::DANGER )
								->icon( 'bs.trash' )
								->confirm( __( 'Delete this text?' ) )
						] );
				} ),
		];
	}
}
