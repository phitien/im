<?php

namespace App\IM\Models\User\Traits;

use App\IM\Models\User\Relations\Roles;
use App\User;
use App\IM\Models\Role;

trait RoleTrait
{
	/**
	 *
	 * @var User
	 */
	private static $_instanceGuest = null;
	/**
	 *
	 * @return User guest
	 */
	public static function getGuest() {
		if (null === static::$_instanceGuest) {
			static::$_instanceGuest = new User ( [ 
					'active' => 1 
			] );
		}
		return static::$_instanceGuest;
	}
	/**
	 * check user is guest or not
	 *
	 * @return boolean
	 */
	public function isGuest() {
		return $this == static::getGuest ();
	}
	/**
	 * Create Superadmin
	 *
	 * @param array $attributes        	
	 * @return User
	 */
	public static function createSuperadmin(array $attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( Role::getSupreme () );
		return $user;
	}
	/**
	 * Create manager
	 *
	 * @param array $attributes        	
	 * @return User
	 */
	public static function createManager(array $attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( Role::getManager () );
		return $user;
	}
	/**
	 * Create normal user
	 *
	 * @param array $attributes        	
	 * @return User
	 */
	public static function createUser(array $attributes) {
		unset ( $attributes ['active'] );
		$user = static::create ( $attributes );
		$user->roles ()->attach ( Role::getUser () );
		return $user;
	}
	/**
	 * Return the roles that belong to the user.
	 * @return Roles
	 */
	public function roles() {
		return (new Roles ( $this, $this->getBelongsToManyCaller () ));
	}
}