<?php

namespace App\Media\Traits;

use App\Media\Config\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Media\Config\LocationMap;

trait LocationTrait
{
	/**
	 *
	 * @var string
	 */
	protected static $_location_id;
	/**
	 *
	 * @var array
	 */
	protected static $_location;
	/**
	 *
	 * @return string encrypted location id
	 */
	protected static function getLocationId() {
		if (! static::$_location_id) {
			static::$_location_id = request ()->get ( Config::LOCATION_KEY, request ()->header ( Config::LOCATION_KEY, Cookie::get ( Config::LOCATION_KEY, null ) ) );
		}
		return static::$_location_id;
	}
	/**
	 *
	 * @param int $location_id        	
	 */
	protected static function setLocationId($location_id) {
		static::$_location_id = $location_id;
		static::$_location = LocationMap::find ( static::$_location_id );
	}
	/**
	 *
	 * @return Location
	 */
	protected static function getLocation() {
		$location_id = static::getLocationId ();
		if (! static::$_location) {
			static::$_location = LocationMap::find ( $location_id );
		}
		return static::$_location ? static::$_location : LocationMap::earth ();
	}
}
