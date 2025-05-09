<?php

namespace App\Orchid\Layouts\Text;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class TextEditLayout extends Rows
{
	/**
	 * Used to create the title of a group of form elements.
	 *
	 * @var string|null
	 */
	protected $title;

	/**
	 * Get the fields elements to be displayed.
	 *
	 * @return Field[]
	 */
	protected function fields() : iterable
	{
		return [
			Input::make( 'text.title' )
				->required()
				->title( 'Название' ),
			TextArea::make( 'text.text' )
				->required()
				->rows( 20 )
				->title( 'Текст' ),
		];
	}
}
