<?php

namespace App\Ezsell\Traits;

use App\Ezsell\Config;

trait ModeTrait {
	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public static function getMode() {
		if (! \App\Ezsell\Helper::$_mode) {
			\App\Ezsell\Helper::$_mode = static::param ( 'mode', Config::$modes ['SELL'] );
		}
		return \App\Ezsell\Helper::$_mode;
	}
	protected static function setMode($mode) {
		\App\Ezsell\Helper::$_mode = ( int ) $mode > 0 ? Config::$modes ['SELL'] : Config::$modes ['BUY'];
	}
}