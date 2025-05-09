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
		Schema::create( 'texts', function ( Blueprint $table ) {
			$table->id();

			$table->string( 'title' );
			$table->text( 'text' );

			$table->unsignedInteger( 'words_count' );
			$table->unsignedInteger( 'symbols_count' );

			$table->unsignedBigInteger( 'user_id' )->nullable();
			$table->foreign( 'user_id' )
				->references( 'id' )
				->on( 'users' )
				->cascadeOnDelete();

			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 */
	public function down() : void
	{
		Schema::dropIfExists( 'texts' );
	}
};
