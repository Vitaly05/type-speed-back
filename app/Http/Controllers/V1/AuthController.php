<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConfirmResetCodeRequest;
use App\Http\Requests\Auth\LoginByEmailRequest;
use App\Http\Requests\Auth\LoginByNameRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequestRequest;
use App\Mail\ResetPasswordRequestMail;
use App\Models\ResetPasswordCode;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
	public function register( RegistrationRequest $request )
	{
		$name = trim( $request->input( 'name' ) );
		$email = trim( $request->input( 'email' ) );
		$password = trim( $request->input( 'password' ) );

		$user = User::query()->create( [
			'email' => $email,
			'name' => $name,
			'password' => Hash::make( $password ),
		] );

		return $this->tokenResponse( $user );
	}

	public function loginByEmail( LoginByEmailRequest $request )
	{
		$email = trim( $request->input( 'email' ) );
		$password = trim( $request->input( 'password' ) );

		$user = User::query()->where( 'email', $email )->first();

		if ( !$user || !Hash::check( $password, $user->password ) ) {
			return response()->json( [
				'success' => false,
				'message' => __( 'Invalid credentials' ),
			] );
		}

		return $this->tokenResponse( $user );
	}

	public function loginByName( LoginByNameRequest $request )
	{
		$name = trim( $request->input( 'name' ) );
		$password = trim( $request->input( 'password' ) );

		$user = User::query()->where( 'name', $name )->first();

		if ( !$user || !Hash::check( $password, $user->password ) ) {
			return response()->json( [
				'success' => false,
				'message' => __( 'Invalid credentials' ),
			] );
		}

		return $this->tokenResponse( $user );
	}

	public function resetPasswordRequest( ResetPasswordRequestRequest $request )
	{
		$email = $request->input( 'email' );

		$code = random_int( 100000, 999999 );

		$reset_password_code = ResetPasswordCode::query()
			->where( [
				'email' => $email,
				'is_used' => false,
			] )
			->first();

		if ( $reset_password_code ) {
			$reset_password_code->is_used = true;
			$reset_password_code->save();
		}

		ResetPasswordCode::query()->create( [
			'email' => $email,
			'code' => Hash::make( $code ),
		] );

		Mail::to( $email )->send( new ResetPasswordRequestMail( $code ) );

		return response()->json( [
			'success' => true,
		] );
	}

	public function confirmResetCode( ConfirmResetCodeRequest $request )
	{
		$email = $request->input( 'email' );
		$code = $request->input( 'code' );

		return response()->json( [
			'success' => $this->isCodeCorrect( $code, $email ),
		] );
	}

	public function resetPassword( ResetPasswordRequest $request )
	{
		$email = trim( $request->input( 'email' ) );
		$code = trim( $request->input( 'code' ) );
		$password = trim( $request->input( 'password' ) );

		if ( !$this->isCodeCorrect( $code, $email ) ) {
			return $this->incorrectResetCodeResponse();
		}

		$user = User::query()->where( 'email', $email )->first();

		if ( !$user ) {
			return $this->userNotFoundResponse();
		}

		$user->password = Hash::make( $password );
		$user->save();

		return response()->json( [
			'success' => true,
		] );
	}

	protected function isCodeCorrect( $code, $email )
	{
		$reset_password_code = ResetPasswordCode::query()
			->where( [
				'email' => $email,
				'is_used' => false,
			] )
			->first();

		if ( !$reset_password_code ) {
			return $this->codeNotFoundResponse();
		}

		return Hash::check( $code, $reset_password_code->code );
	}

	protected function tokenResponse( User $user )
	{
		$token = $user->createToken( 'api-token' )->plainTextToken;

		return response()->json( [
			'success' => true,
			'access_token' => $token,
		] );
	}

	protected function codeNotFoundResponse() : JsonResponse
	{
		return response()->json( [
			'success' => false,
			'message' => __( 'Code not found' ),
		], 404 );
	}

	protected function incorrectResetCodeResponse() : JsonResponse
	{
		return response()->json( [
			'success' => false,
			'message' => __( 'Code is not correct' ),
		], 400 );
	}

	protected function userNotFoundResponse() : JsonResponse
	{
		return response()->json( [
			'success' => false,
			'message' => __( 'User not found' ),
		], 404 );
	}
}
