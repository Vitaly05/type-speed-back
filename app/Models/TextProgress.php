<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextProgress extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'text_id',
		'words_per_minute',
		'symbols_per_minute',
	];

	public function user()
	{
		return $this->belongsTo( User::class, 'user_id', 'id' );
	}

	public function text()
	{
		return $this->belongsTo( Text::class, 'text_id', 'id' );
	}
}
