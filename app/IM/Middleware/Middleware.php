<?php

namespace App\IM\Middleware;

use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Closure;
use App\IM\Config\Config;
use Illuminate\Http\Response;
use App\IM\Traits\MailerTrait;
use App\IM\Traits\UserTrait;
use App\IM\Traits\ResponseTrait;
use App\IM\Traits\EncoderTrait;

abstract class Middleware extends BaseMiddleware implements IMiddleware {
	/**
	 * TRAITS
	 */
	use EncoderTrait, MailerTrait, UserTrait, ResponseTrait;
	/**
	 *
	 * @var array
	 */
	protected $except = [ ];
	/**
	 * Determine if the request has a URI that should pass through CSRF verification.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return bool
	 */
	protected function shouldPassThrough($request) {
		foreach ( $this->except as $except ) {
			if ($except !== '/') {
				$except = trim ( $except, '/' );
			}
			if ($request->is ( $except )) {
				return true;
			}
		}
		return false;
	}
	/**
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param Closure $next        	
	 * @param string $action        	
	 * @return \Illuminate\Http\Response
	 */
	public function handle($request, Closure $next, $actions = Config::ACTION_GUEST_ACT) {
		if ($this->shouldPassThrough ( $request )) {
			return $next ( $request );
		} else {
			return $this->im_handle ( $request, $next, $actions );
		}
	}
}
