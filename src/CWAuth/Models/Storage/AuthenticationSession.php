<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 28-10-15 - 22:08
 */

namespace CWAuth\Models\Storage;

use CWAuth\Helper\Arr;


class AuthenticationSession
{
	const SESSION_PREFIX = "authentication";

	protected $sessionBag = [ ];

	public function __construct()
	{

	}

	public function writeSessionData( Array $data )
	{
		foreach( $data as $key => $value )
		{
			$_SESSION[ self::SESSION_PREFIX ][ $key ] = $value;
			$this->sessionBag[$key] = $value;
		}
	}

	public function removeSessionData()
	{
		$_SESSION[ self::SESSION_PREFIX ] = null;
		$this->sessionBag = null;
	}


}