<?php

namespace App\Ezsell\Middleware;

use Closure;
use App\Ezsell\Config;
use App\Ezsell\Config\LocationMap;

class Location extends Middleware {
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $actions        	
	 * @return \Illuminate\Http\Response
	 */
	public function im_handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		$location = static::getLocation ();
		if (! $location || $location == LocationMap::earth ()) {
			return $this->response ( view ( 'location' ) );
		}
		return $next ( $request );
	}
}
