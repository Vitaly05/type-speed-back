<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up() : void
	{
		Schema::create( 'text_progress', function ( Blueprint $table ) {
			$table->id();

			$table->unsignedBigInteger( 'user_id' );
			$table->foreign( 'user_id' )
				->references( 'id' )
				->on( 'users' )
				->cascadeOnDelete();

			$table->unsignedBigInteger( 'text_id' );
			$table->foreign( 'text_id' )
				->references( 'id' )
				->on( 'texts' )
				->cascadeOnDelete();

			$table->unsignedInteger( 'words_per_minute' );
			$table->unsignedInteger( 'symbols_per_minute' );

			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 */
	public function down() : void
	{
		Schema::dropIfExists( 'text_progress' );
	}
};
