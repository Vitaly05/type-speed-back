<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\TextController;
use App\Http\Middleware\OptionalSanctumAuth;
use Illuminate\Support\Facades\Route;

Route::controller( AuthController::class )
	->prefix( 'auth' )
	->group( function () {
		Route::post( 'register', 'register' );
		Route::post( 'login-email', 'loginByEmail' );
		Route::post( 'login-name', 'loginByName' );
	} );

Route::controller( TextController::class )
	->prefix( 'text' )
	->group( function () {
		Route::get( 'all', 'all' )->middleware( OptionalSanctumAuth::class );
		Route::get( 'all-user/{user_id}', 'allWithUserId' );

		Route::middleware( 'auth:sanctum' )
			->group( function () {
				Route::get( 'all-my', 'allWithCurrentUserId' );

				Route::post( 'create', 'create' );
				Route::post( '{id}/edit', 'edit' );
			} );
	} );
