<?php

namespace App\Media\Middleware;

use Closure;
use App\Media\Config\Config;
use Illuminate\Http\Response;

class Authentication extends Middleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $action        	
	 * @return \Illuminate\Http\Response
	 */
	public function im_handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		if (static::getUser ()->isGuest ()) {
			return $this->jsonResponse ( 'unauthorised', null, Response::HTTP_UNAUTHORIZED );
		}
		return $next ( $request );
	}
}
