<?php

namespace App\Shared\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response;

class ItemNotFound extends JWTException {
	/**
	 *
	 * @var int
	 */
	protected $statusCode = Response::HTTP_BAD_REQUEST;
	/**
	 *
	 * @var string
	 */
	protected $message = 'item_not_found';
}
