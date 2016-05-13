<?php

namespace App\Ezsell\Controllers\Traits;

use App\Ezsell\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;

trait  LoginTrait {
	/**
	 * Return a JWT
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request) {
		return $this->process ( 'login', func_get_args () );
	}
	protected function postLogin(Request $request) {
		$credentials = $request->only ( 'email', 'password' );
		$response = $this->doLogin ( $credentials );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->redirect ( static::getRedirectUri () );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'login', [ 
					'appMessage' => "Hỏng rồi, không login được, lý do vì {$data['message']}. Thử lại phát đi" 
			] ), $response->getStatusCode () );
		}
	}
	protected function getLogin(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->response ( view ( 'login' ) );
		else
			return $this->redirect ();
	}
	/**
	 * Login
	 *
	 * @param array $credentials        	
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogin(array $credentials = []) {
		return static::apiCallLogin ( $credentials );
	}
	/**
	 * Logout
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout() {
		return $this->doLogout ();
	}
	/**
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogout() {
		$response = static::apiCallLogout ();
		static::setToken ( Config::INVALID_TOKEN );
		return $this->redirect ();
	}
}
