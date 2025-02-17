<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class Text extends Model
{
	use HasFactory, AsSource, Filterable;

	protected $fillable = [
		'title',
		'text',
		'words_count',
		'symbols_count',
	];

	protected $allowedSorts = [
		'id',
		'title',
		'created_at',
		'updated_at',
	];

	protected $allowedFilters = [
		'id' => Where::class,
		'title' => Like::class,
	];

	protected static function boot()
	{
		parent::boot();

		static::creating( function ( Text $model ) {
			$model->formatText();
			$model->formatTitle();
			$model->calculateTextParams();
		} );

		static::updating( function ( Text $model ) {
			if ( $model->isDirty( 'text' ) ) {
				$model->formatText();
				$model->calculateTextParams();
			}

			if ( $model->isDirty( 'title' ) ) {
				$model->formatTitle();
			}
		} );
	}

	protected function calculateTextParams()
	{
		$text_array = explode( ' ', $this->text );

		$this->words_count = count( $text_array );
		$this->symbols_count = strlen( $this->text );
	}

	protected function formatTitle()
	{
		$title = trim( $this->title );
		$cleanedText = preg_replace( '/[^\p{L}\p{N}\s]/u', '', $title );

		$this->title = preg_replace( '/\s+/u', ' ', $cleanedText );
	}

	protected function formatText()
	{
		$text = trim( $this->text );
		$cleanedText = preg_replace( '/[^\p{L}\p{N}\s.,]/u', '', $text );

		$this->text = preg_replace( '/\s+/u', ' ', $cleanedText );
	}

	public function progresses()
	{
		return $this->hasMany( TextProgress::class, 'text_id', 'id' );
	}
}
