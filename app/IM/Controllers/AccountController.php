<?php

namespace App\IM\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Hash;
use App\IM\Response\Status;
use Illuminate\Http\Response;

class AccountController extends AuthenticableController {
	/**
	 *
	 * @var array $_authenticationMiddlewareOptions
	 */
	protected $_authenticationMiddlewareOptions = [ 
			'except' => [ 
					'reset' 
			] 
	];
	/**
	 *
	 * @var array $_authorizationMiddlewareOptions
	 */
	protected $_authorizationMiddlewareOptions = [ ];
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function passwordValidator(array $data) {
		$validator = Validator::make ( $data, [ 
				'password' => 'required|min:6' 
		] );
		if ($validator->fails ()) {
			return 'invalid_password';
		}
		$validator = Validator::make ( $data, [ 
				'password' => 'confirmed' 
		] );
		if ($validator->fails ()) {
			return 'password_confirmation_not_matched';
		}
	}
	/**
	 *
	 * @param Request $request        	
	 * @return Response void
	 */
	protected function enterWrongPassword(Request $request) {
		$current_password = $request->get ( 'current_password' );
		if (! $current_password) {
			return $this->jsonResponse ( 'current_password_not_provided', null, Status::PreconditionRequired );
		}
		if (strlen ( $current_password ) > 0 && ! Hash::check ( $current_password, $this->_user->password )) {
			return $this->jsonResponse ( 'current_password_incorrect', null, Status::PreconditionFailed );
		}
		return false;
	}
	/**
	 * Return the authenticated user
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function password(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		if ($msg = $this->passwordValidator ( $request->all () )) {
			return $this->jsonResponse ( $msg, null, Status::PreconditionFailed );
		}
		$new_password = $request->get ( 'password' );
		if (Hash::check ( $new_password, $this->_user->password )) {
			return $this->jsonResponse ( 'same_new_password', null, Status::PreconditionFailed );
		}
		$this->_user->password = $this->encode ( $new_password );
		$this->_user->save ();
		$credentials = [ 
				'email' => $this->_user->email,
				'password' => $new_password 
		];
		return $this->doLogin ( $credentials );
	}
	/**
	 * Reset: send reset link to the user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function reset(Request $request) {
		// TODO
	}
	/**
	 * Email: change user email
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function email(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		// TODO
	}
	/**
	 * Account: change user account
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function account(Request $request) {
		if ($response = $this->enterWrongPassword ( $request )) {
			return $response;
		}
		// TODO
	}
}