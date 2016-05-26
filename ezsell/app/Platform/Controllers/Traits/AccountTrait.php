<?php

namespace App\Platform\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Platform\Config;

trait AccountTrait {
	protected function getPageResponseDataOfAccountTrait() {
		return $this->getPageResponseData ()->setShowBanner ( false );
	}
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function password(Request $request) {
		return $this->process ( 'password', func_get_args () );
	}
	protected function ppostPassword(Request $request) {
		$data = $request->only ( 'current_password', 'password', 'password_confirmation' );
		$response = static::apiCallPassword ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			// static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangePasswordPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.password_changed' ) ) ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangePasswordPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.password_change_failed', $data ) ) ), $response->getStatusCode () );
		}
	}
	protected function pgetPassword(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->getLoginResponse ();
		else
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangePasswordPage' ) ) );
	}
	/**
	 * Email: change user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function email(Request $request) {
		return $this->process ( 'email', func_get_args () );
	}
	protected function ppostEmail(Request $request) {
		$data = $request->only ( 'current_password', 'email', 'email_confirmation' );
		$response = static::apiCallEmail ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			// static::setToken ( Config::INVALID_TOKEN );
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangeEmailPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.email_changed' ) ) ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangeEmailPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.email_change_failed', $data ) ) ), $response->getStatusCode () );
		}
	}
	protected function pgetEmail(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->getLoginResponse ();
		else
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangeEmailPage' ) ) );
	}
	/**
	 * Account: change user account
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function account(Request $request) {
		return $this->process ( 'account', func_get_args () );
	}
	protected function ppostAccount(Request $request) {
		$data = $request->only ( 'current_password', 'name' );
		$response = static::apiCallAccount ( $data );
		if ($response->getStatusCode () == Response::HTTP_OK) {
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangeAccountPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.account_changed' ) ) ) );
		} else {
			$data = static::json_decode ( $response->getBody (), true );
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangeAccountPage' )->

			setAppMessage ( $this->getTransMessage ( 'messages.sentences.account_change_failed', $data ) ) ), $response->getStatusCode () );
		}
	}
	protected function pgetAccount(Request $request) {
		if (static::getUser ()->isGuest ())
			return $this->getLoginResponse ();
		else
			return $this->response ( view ( 'base', $this->getPageResponseDataOfAccountTrait ()->setType ( 'ChangeAccountPage' ) ) );
	}
	/**
	 * Reset: send reset link to the user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function reset(Request $request) {
		// TODO
		return $this->process ( 'reset', func_get_args () );
	}
}