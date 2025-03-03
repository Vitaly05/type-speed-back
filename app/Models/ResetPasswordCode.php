<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPasswordCode extends Model
{
	protected $fillable = [
		'email',
		'code',
		'is_used',
	];
}
