<?php

namespace App\Platform;

use Hash;
use App\Platform\Models\Role;
use App\Platform\Models\Action;

class Config {
	public static $modes = [ 
			'SELL' => 1,
			'BUY' => 0 
	];
	const PAGE_SIZE = 18;
	const USE_CODE = true;
	const HOME_PAGE = '/';
	const INVALID_TOKEN = 'INVALID_TOKEN';
	const IM_BASE_URL = 'http://im.ezsell.com';
	const MEDIA_BASE_URL = 'http://media.ezsell.com';
	const SOCKET_SERVER_URL = 'http://localhost:8890';
	const LOCATION_KEY = 'location';
	const REQUEST_TIME = 'requesttime';
	const MODE = 'mode';
	const DATETIME_DB_FORMAT = 'Y-m-d H:i:s';
	/**
	 *
	 * @var unknown
	 */
	const TOKEN_EXPIRING_TIME = 7200; // 60 * 120
	                                  //
	const MAIL_SUBJECT_PREFIX = "email_subject_prefix";
	//
	const TOKEN_KEY = "TOKEN-KEY";
	const SESSION_KEY = "SESSION-KEY";
	//
	const FOLLOWER_REQUESTED = 0;
	const FOLLOWER_REQUEST_ACCEPTED = 1;
	const FOLLOWER_REQUEST_REFUSED = 2;
	//
	const ACTION_GUEST_ACT = 'GUEST_ACT';
	const ACTION_GOD_ACT = 'GOD_ACT';
	const ACTION_OWN_ACT = 'OWN_ACT';
	const ACTION_MANAGER_ACT = 'MANAGER_ACT';
	const ACTION_CREATE_USER = 'CREATE_USER';
	const ACTION_ACCESS_USER = 'ACCESS_USER';
	const ACTION_CREATE_ROLE = 'CREATE_ROLE';
	const ACTION_ACCESS_ROLE = 'ACCESS_ROLE';
	const ACTION_CREATE_ACTION = 'CREATE_ACTION';
	const ACTION_ACCESS_ACTION = 'ACCESS_ACTION';
	//
	const ROLE_SUPREME = 'SUPREME';
	const ROLE_MANAGER = 'MANAGER';
	const ROLE_USER = 'USER';
	const ROLE_GUEST = 'GUEST';
	/**
	 *
	 * @return array
	 */
	public static function getCoreActions() {
		$coreActions [static::ACTION_GOD_ACT] = 'God action';
		$coreActions [static::ACTION_MANAGER_ACT] = 'Manager action';
		$coreActions [static::ACTION_OWN_ACT] = 'Own action';
		$coreActions [static::ACTION_GUEST_ACT] = 'Guest action';
		$coreActions [static::ACTION_CREATE_USER] = 'Create User';
		$coreActions [static::ACTION_ACCESS_USER] = 'Update/Activate/Deactivate/View User';
		$coreActions [static::ACTION_CREATE_ROLE] = 'Create Role';
		$coreActions [static::ACTION_ACCESS_ROLE] = 'Update/Delete/View Role';
		$coreActions [static::ACTION_CREATE_ACTION] = 'Create Action';
		$coreActions [static::ACTION_ACCESS_ACTION] = 'Update/Delete/View Action';
		return array_merge ( $coreActions, [ 
				'CREATE' => 'Create',
				'UPDATE' => 'Update',
				'DELETE' => 'Delete/Remove',
				'VIEW' => 'View',
				'ACCESS' => 'Access',
				'SEND' => 'Send',
				'INVITE' => 'Invite',
				'CHAT' => 'Chat',
				'POST' => 'Post',
				'TAG' => 'Tag',
				'SHARE' => 'Share',
				'EDIT' => 'Edit',
				'COMMENT' => 'Comment',
				'LIKE' => 'Like',
				'FOLLOW' => 'Follow' 
		] );
	}
	/**
	 *
	 * @return array
	 */
	public static function getCoreRoles() {
		$coreRoles [static::ROLE_SUPREME] = 'Supreme';
		$coreRoles [static::ROLE_MANAGER] = 'Manager';
		$coreRoles [static::ROLE_USER] = 'User';
		$coreRoles [static::ROLE_GUEST] = 'Guest';
		return $coreRoles;
	}
	/**
	 *
	 * @return array
	 */
	public static function getSuperadminData() {
		return [ 
				'name' => 'superadmin',
				'email' => 'superadmin@gmail.com',
				'password' => Hash::make ( 'superadmin' ) 
		];
	}
	/**
	 *
	 * @return array
	 */
	public static function getManagerData() {
		return [ 
				'name' => 'manager',
				'email' => 'manager@gmail.com',
				'password' => Hash::make ( 'manager' ) 
		];
	}
	/**
	 *
	 * @return array
	 */
	public static function getUserData() {
		return [ 
				'name' => 'user',
				'email' => 'user@gmail.com',
				'password' => Hash::make ( 'user12' ) 
		];
	}
	/**
	 *
	 * @param Role $role        	
	 * @return array
	 */
	public static function getRoleCoreActions(Role $role) {
		switch ($role->code) {
			case static::ROLE_SUPREME :
				return [ 
						static::ACTION_GOD_ACT 
				];
			case static::ROLE_MANAGER :
				return [ 
						static::ACTION_MANAGER_ACT,
						static::ACTION_OWN_ACT,
						static::ACTION_CREATE_USER,
						static::ACTION_ACCESS_USER,
						static::ACTION_CREATE_ROLE,
						static::ACTION_ACCESS_ROLE,
						static::ACTION_CREATE_ACTION,
						static::ACTION_ACCESS_ACTION 
				];
			case static::ROLE_USER :
				return [ 
						static::ACTION_OWN_ACT 
				];
			case static::ROLE_GUEST :
			default :
				return [ 
						static::ACTION_GUEST_ACT 
				];
		}
	}
}