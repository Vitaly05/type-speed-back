<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopResult extends Model
{
	protected $fillable = [
		'user_id',
		'symbols_per_minute',
	];

	public function user()
	{
		return $this->belongsTo( User::class, 'user_id', 'id' );
	}
}
