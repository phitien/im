<?php

namespace App\IM\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

trait SocietyTrait {
	/**
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function followers(Request $request) {
		return $this->jsonResponse ( 'get_followers_successfully', $this->_user->followers );
	}
	/**
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function following(Request $request) {
		return $this->jsonResponse ( 'get_following_successfully', $this->_user->following );
	}
	/**
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function follow(Request $request, $id) {
		$user = User::find ( $id );
		if (! $user) {
			return $this->jsonResponse ( 'cannot_find_user', 'User not found', Response::HTTP_BAD_REQUEST );
		}
		if ($this->_user->follow ( $user ))
			return $this->jsonResponse ( 'follow_successfully', '' );
		else
			return $this->jsonResponse ( 'follow_unsuccessfully', 'Some error occurs.', Response::HTTP_BAD_REQUEST );
	}
	/**
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function accept(Request $request, $id) {
		$user = User::find ( $id );
		if (! $user) {
			return $this->jsonResponse ( 'cannot_find_user', 'User not found', Response::HTTP_BAD_REQUEST );
		}
		if ($this->_user->accept ( $user ))
			return $this->jsonResponse ( 'accept_successfully', '' );
		else
			return $this->jsonResponse ( 'accept_unsuccessfully', 'Some error occurs.', Response::HTTP_BAD_REQUEST );
	}
	/**
	 *
	 * @param Request $request        	
	 * @return Response
	 */
	public function refuse(Request $request, $id) {
		$user = User::find ( $id );
		if (! $user) {
			return $this->jsonResponse ( 'cannot_find_user', 'User not found', Response::HTTP_BAD_REQUEST );
		}
		if ($this->_user->refuse ( $user ))
			return $this->jsonResponse ( 'refuse_successfully', '' );
		else
			return $this->jsonResponse ( 'refuse_unsuccessfully', 'Some error occurs.', Response::HTTP_BAD_REQUEST );
	}
}
