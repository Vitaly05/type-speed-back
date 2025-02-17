<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionalSanctumAuth
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
	 */
	public function handle( Request $request, Closure $next ) : Response
	{
		if ( $request->bearerToken() ) {
			auth()->setUser( auth( 'sanctum' )->user() );
		}

		return $next( $request );
	}
}
