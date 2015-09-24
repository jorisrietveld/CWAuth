<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-9-15 - 23:31
 * Licence: GPLv3
 */

namespace CWAuth\Models;

class Arr
{
	public static function isAssoc( $array )
	{
		return array_keys( $array ) !== range(0, count( $array ) - 1);
	}
}