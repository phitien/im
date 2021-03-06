<?php

namespace App\Media\Traits;

use App\Media\Config;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Image;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

trait ResponseTrait
{
	/**
	 *
	 * @param BaseResponse $response        	
	 */
	protected static function addHeaders(BaseResponse $response) {
		$response = static::addCookieToResponse ( $response, Config::TOKEN_KEY, static::getToken () );
		return $response;
	}
	/**
	 *
	 * @param BaseResponse $response        	
	 */
	protected static function clearHeaders(BaseResponse $response) {
		$response = static::addCookieToResponse ( $response, Config::TOKEN_KEY, null );
		return $response;
	}
	/**
	 *
	 * @return Response $response
	 */
	protected function getTransMessage($message, $data) {
		if ($data) {
			$reason = $data ['message'] ? $data ['message'] : $data;
			return trans ( $message, [ 
					'reason' => trans ( "messages.errors.{$reason}" ) 
			] );
		} else
			trans ( $message );
	}
	/**
	 * Build response
	 *
	 * @param string $to        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @param bool $secure        	
	 * @return \Illuminate\Http\Response
	 */
	public function redirect($to = Config::HOME_PAGE, $status = 302, $headers = [], $secure = null) {
		return static::addHeaders ( redirect ( $to, $status, $headers, $secure ) );
	}
	/**
	 *
	 * @param string $content        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\Response
	 */
	public function response($content, $status = Response::HTTP_OK, array $headers = []) {
		return static::addHeaders ( response ( $content, $status, $headers ) );
	}
	/**
	 *
	 * @param string $message        	
	 * @param string $data        	
	 * @param number $status        	
	 * @param array $headers        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function jsonResponse($message = null, $data = null, $status = Response::HTTP_OK, array $headers = []) {
		return $this->addHeaders ( response ()->json ( [ 
				'message' => $message,
				'data' => $data instanceof PageResponseData ? $data->getData () : $data 
		], $status, $headers ) );
	}
	/**
	 *
	 * @param Response $response        	
	 * @param string $message        	
	 * @param string $data        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateJsonResponse(JsonResponse $response, $message = null, $data = null) {
		return $response->setData ( [ 
				'message' => $message,
				'data' => $data instanceof PageResponseData ? $data->getData () : $data 
		] );
	}
	/**
	 *
	 * @param string $path        	
	 */
	public function pumpImagePath($path = '') {
		if ($path)
			$this->pumpImage ( Image::make ( $path ) );
	}
	/**
	 *
	 * @param Image $image        	
	 */
	public function pumpImage($image) {
		header ( "Content-Type: $image->mime ()" );
		die ( $image->encode () );
	}
	/**
	 */
	public function pumpNoImage() {
		$this->pumpImagePath ( '../repo/not-found.jpg' );
	}
	/**
	 */
	public function pumpUnauthenticated() {
		$this->pumpImagePath ( '../repo/unauthenticated.jpg' );
	}
	/**
	 */
	public function pumpUnauthorized() {
		$this->pumpImagePath ( '../repo/unauthorized.jpg' );
	}
}
