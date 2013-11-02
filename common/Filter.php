<?php

namespace common;

class Filter {
	
	/**
	 * @param String $string
	 */
	public static function needSanitize($string) {
		
		$sanitized = ltrim($string);
		$sanitized = rtrim($sanitized);
		$sanitized = strip_tags($sanitized);
		$sanitized = stripslashes($sanitized);
		$sanitized = mysql_real_escape_string($sanitized);

		if ($sanitized != $string)
			return true;
		
		return false;
	}
	
	/**
	 * @param String $string
	 */
	public static function sanitize($string) {
		$string = ltrim($string);
		$string = rtrim($string);
		$string = strip_tags($string);
		$string = stripslashes($string);
		$string = mysql_real_escape_string($string);
		return $string;
	}
}
