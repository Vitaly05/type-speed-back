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
		Schema::create( 'top_results', function ( Blueprint $table ) {
			$table->id();

			$table->unsignedBigInteger( 'user_id' )->unique();
			$table->foreign( 'user_id' )
				->references( 'id' )
				->on( 'users' )
				->cascadeOnDelete();

			$table->unsignedInteger( 'symbols_per_minute' );

			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 */
	public function down() : void
	{
		Schema::dropIfExists( 'top_results' );
	}
};
