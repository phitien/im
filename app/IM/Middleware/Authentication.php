<?php

namespace App\IM\Middleware;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;
use Closure;
use App\IM\Config;
use App\IM\Response\Status;
use App\IM\Exceptions\TokenNotFound;

class Authentication extends Middleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @return \Illuminate\Http\Response
	 */
	public function handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		try {
			$user = $this->getUser ( $request, true );
		} catch ( TokenNotFound $e ) {
			return $this->jsonResponse ( 'token_not_found', null, Status::BadRequest );
		} catch ( TokenExpiredException $e ) {
			return $this->jsonResponse ( 'token_expired', null, Status::BadRequest );
		} catch ( TokenInvalidException $e ) {
			return $this->jsonResponse ( 'token_invalid', null, Status::BadRequest );
		} catch ( Exception $e ) {
			return $this->jsonResponse ( 'token_absent', null, Status::BadRequest );
		}
		if (! $user || $user->isGuest ())
			return $this->jsonResponse ( 'user_not_found', null, 404 );
		$this->events->fire ( 'tymon.jwt.valid', $user );
		
		return parent::handle ( $request, $next, $actions );
	}
}
