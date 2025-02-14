<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginByEmailRequest;
use App\Http\Requests\Auth\LoginByNameRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

	protected function tokenResponse( User $user )
	{
		$token = $user->createToken( 'api-token' )->plainTextToken;

		return response()->json( [
			'success' => true,
			'access_token' => $token,
		] );
	}
}
