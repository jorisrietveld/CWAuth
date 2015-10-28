<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 19:51
 * Licence: GPLv3
 */

namespace CWAuth\Models\Storage;

use CWAuth\Helper\Arr;


class Session
{
	const SESSION_COOKIE_NAME = "CampusWerkSession";
	const SESSION_PREFIX      = "auth";

	const SESSION_DOMAIN    = "";
	const SESSION_SECURE    = false;
	const SESSION_HTTP_ONLY = true;
	const SESSION_PATH      = "/";
	const SESSION_LIFETIME  = 0;

	protected $sessionCookieParams;
	protected $sessionData;

	/**
	 * Initialize the object.
	 *
	 * @param array $sessionCookieParams
	 */
	public function __construct( $sessionCookieParams = [ ] )
	{
		$this->sessionCookieParams = $sessionCookieParams;
	}

	/**
	 * Start an session with the settings set by the argument or constants set in this class.
	 *
	 * @param array $sessionCookieParams
	 */
	public function sessionStart( $sessionCookieParams = [ ] )
	{
		$this->sessionCookieParams = $sessionCookieParams;

		if( session_status() == PHP_SESSION_NONE )
		{
			$lifetime = self::SESSION_LIFETIME;
			$path     = self::SESSION_PATH;
			$domain   = self::SESSION_DOMAIN;
			$secure   = self::SESSION_SECURE;
			$httponly = self::SESSION_HTTP_ONLY;

			// If there are cookie params set in the constructor override the just defined variables.
			extract( $this->sessionCookieParams, EXTR_OVERWRITE );

			//$this->setCookieParams( $lifetime, $path, $domain, $secure, $httponly );
			session_name( self::SESSION_COOKIE_NAME );
			// Finally start the session and define the authentication session.
			session_start();
			$_SESSION[ self::SESSION_PREFIX ] = [ ];
		}
	}

	/**
	 * Return the session get cookie params configured in php.ini or the overridden params after calling set cookie
	 * params.
	 */
	public function getCookieParams()
	{
		$this->sessionCookieParams = session_get_cookie_params();
	}

	/**
	 * Set the session runtime settings. do not use this function after the session has started it will have no effect.
	 *
	 * @param $lifetime
	 * @param $path
	 * @param $domain
	 * @param $secure
	 * @param $httponly
	 */
	public function setCookieParams( $lifetime, $path, $domain, $secure, $httponly )
	{
		session_set_cookie_params( $lifetime, $path, $domain, $secure, $httponly );
	}

	/**
	 * Set data to an prefixed key in the session array.
	 *
	 * @param array $data
	 */
	public static function  setAuthenticationData( Array $data )
	{
		$_SESSION[ self::SESSION_PREFIX ] = $data;
	}

	/**
	 * Get data from the session using dot notation.
	 *
	 * @param $key
	 * @return array|bool
	 */
	public static function getAuthenticationData( $key )
	{
		if( Arr::has( $_SESSION[ self::SESSION_PREFIX ], $key ) )
		{
			return Arr::get( $_SESSION[ self::SESSION_PREFIX ], $key );
		}

		return false;
	}

	/**
	 * Get all data stored in the authentication session.
	 *
	 * @return mixed
	 */
	public static function getAllAuthenticationData()
	{
		return $_SESSION[ self::SESSION_PREFIX ];
	}

	public static function regenerateId( $resetSessionData = false )
	{
		if( $resetSessionData )
		{
			session_regenerate_id( true );
			$_SESSION[ self::SESSION_PREFIX ];
		}
		else
		{
			session_regenerate_id();
		}
	}

}