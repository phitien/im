<?php

namespace App\Media\Controllers;

use Validator;
use App\Media\Traits\UserTrait;

abstract class AuthenticableController extends Controller {
	/**
	 * Traits
	 */
	use UserTrait;
	/**
	 * Validate user email
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validateEmail(array $data) {
		$validator = Validator::make ( $data, [ 
				'email' => 'required|email|max:255' 
		] );
		if ($validator->fails ()) {
			return 'invalid_email';
		}
		$validator = Validator::make ( $data, [ 
				'email' => 'confirmed' 
		] );
		if ($validator->fails ()) {
			return 'email_confirmation_not_matched';
		}
	}
	/**
	 * Validate user password
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validatePassword(array $data) {
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
	 * Validate user name
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validateName(array $data) {
		$validator = Validator::make ( $data, [ 
				'name' => 'required|min:3|max:30|regex:/^[a-z0-9]([\._]?[a-z0-9]+)+$/' 
		] );
		if ($validator->fails ()) {
			return 'invalid_name';
		}
	}
	/**
	 * Validate user name
	 *
	 * @param array $data        	
	 * @return string
	 */
	protected function validateProfileData(array $data) {
	}
}
