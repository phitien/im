<?php

namespace App\Platform\Controllers\Traits;

use App\Platform\Config;
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
	protected function ppostLogin(Request $request) {
		$credentials = $request->only ( 'email', 'password' );
		$response = $this->doLogin ( $credentials );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->redirect ( static::getRedirectUri () );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'base', $this->getPageResponseData ()->setType ( 'LoginPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.login_failed', $data ) ) ), $response->getStatusCode () );
		}
	}
	protected function pajaxpostLogin(Request $request) {
		return $this->jsonResponse ( 'login_page', $this->getPageResponseData ()->setType ( 'LoginPage' ) );
	}
	protected function pgetLogin(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->getLoginResponse ();
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
	public function logout(Request $request) {
		return $this->doLogout ( $request );
	}
	/**
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function doLogout(Request $request) {
		$response = static::apiCallLogout ();
		static::setToken ( Config::INVALID_TOKEN );
		return $this->redirect ();
	}
}