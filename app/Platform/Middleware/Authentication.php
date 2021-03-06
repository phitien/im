<?php

namespace App\Platform\Middleware;

use Closure;
use App\Platform\Config;
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
			if ($request->ajax ()) {
				return $this->jsonResponse ( 'unauthenticated', null, Response::HTTP_BAD_REQUEST );
			}
			return $this->getLoginResponse ();
		}
		return $next ( $request );
	}
}
