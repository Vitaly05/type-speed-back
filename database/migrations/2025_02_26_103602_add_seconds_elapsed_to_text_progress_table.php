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
		Schema::table( 'text_progress', function ( Blueprint $table ) {
			$table->unsignedInteger( 'seconds_elapsed' )->default( 0 )->after( 'text_id' );
		} );
	}

	/**
	 * Reverse the migrations.
	 */
	public function down() : void
	{
		Schema::table( 'text_progress', function ( Blueprint $table ) {
			$table->dropColumn( 'seconds_elapsed' );
		} );
	}
};
