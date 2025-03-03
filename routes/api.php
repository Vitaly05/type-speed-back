<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\TextController;
use App\Http\Controllers\V1\TextProgressController;
use App\Http\Middleware\OptionalSanctumAuth;
use Illuminate\Support\Facades\Route;

Route::controller( AuthController::class )
	->prefix( 'auth' )
	->group( function () {
		Route::post( 'register', 'register' );
		Route::post( 'login-email', 'loginByEmail' );
		Route::post( 'login-name', 'loginByName' );
		Route::post( 'send-reset-code', 'resetPasswordRequest' );
		Route::post( 'confirm-reset-code', 'confirmResetCode' );
		Route::post( 'reset-password', 'resetPassword' );
	} );

Route::controller( TextController::class )
	->prefix( 'text' )
	->group( function () {
		Route::middleware( OptionalSanctumAuth::class )
			->group( function () {
				Route::get( 'all', 'all' );
				Route::get( 'all-user/{user_id}', 'allWithUserId' );
				Route::get( 'get/{id}', 'getById' );
			} );

		Route::middleware( 'auth:sanctum' )
			->group( function () {
				Route::get( 'all-my', 'allWithCurrentUserId' );

				Route::post( 'create', 'create' );
				Route::post( '{id}/edit', 'edit' );
				Route::delete( '{id}/delete', 'delete' );
			} );
	} );

Route::controller( TextProgressController::class )
	->prefix( 'text-progress' )
	->group( function () {
		Route::get( 'top-rating', 'getTopRating' );

		Route::middleware( 'auth:sanctum' )
			->group( function () {
				Route::get( 'my-best-result', 'getCurrentUserBestResult' );
				Route::get( 'my-progresses', 'getTextProgress' );

				Route::post( 'save', 'saveResult' );
			} );
	} );
