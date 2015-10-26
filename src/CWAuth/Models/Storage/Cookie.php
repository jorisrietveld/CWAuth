<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 19:51
 * Licence: GPLv3
 */

namespace CWAuth\Models\Storage;

use CWAuth\Helper\DateAndTime;
use CWAuth\Helper\Message;


class Cookie
{
	protected $name     = "";
	protected $value    = "";
	protected $expire   = 0;
	protected $path     = "";
	protected $domain   = "";
	protected $secure   = false;
	protected $httpOnly = true;
	protected $raw      = false;


	public function __construct( $name = "", $value = "", $expire = 0, $path = "", $domain = "", $secure = false, $httpOnly = true, $raw = false )
	{
		$this->name     = $name;
		$this->value    = $value;
		$this->expire   = $expire;
		$this->path     = $path;
		$this->domain   = $domain;
		$this->secure   = $secure;
		$this->httpOnly = $httpOnly;
	}

	public function setCookieSettings( $expire = 0, $path = "", $domain = "", $secure = false, $httpOnly = true )
	{
		$this->expire   = !empty( $expire ) ? $expire : $this->expire;
		$this->path     = !empty( $path ) ? $path : $this->path;
		$this->domain   = !empty( $domain ) ? $domain : $this->domain;
		$this->secure   = !empty( $secure ) ? $secure : $this->secure;
		$this->httpOnly = !empty( $httpOnly ) ? $httpOnly : $this->httpOnly;
	}

	public function writeCookie( $name = "", $value = "", $raw = "" )
	{
		$this->name  = !empty( $name ) ? $name : $this->name;
		$this->value = !empty( $value ) ? $value : $this->value;
		$this->raw   = is_bool( $raw ) ? $raw : $this->raw;

		if( empty( $this->name ) || empty( $this->value ) || $this->expire )
		{
			throw new \LogicException( Message::getMessage( "cookie.exceptions.cookieInvalid" ) );
		}

		if( $this->raw )
		{
			$this->setRawCookie();
		}
		else
		{
			$this->setCookie();
		}
	}

	protected function setCookie()
	{
		setcookie(
			$this->name,
			$this->value,
			$this->expire,
			$this->path,
			$this->domain,
			$this->secure,
			$this->httpOnly
		);
	}

	protected function setRawCookie()
	{
		setrawcookie(
			$this->name,
			$this->value,
			$this->expire,
			$this->path,
			$this->domain,
			$this->secure,
			$this->httpOnly
		);
	}

	public function deleteCookie( $name )
	{
		$this->name = $name;
		$this->setCookieTime( "-1 day" );
		$this->setCookie();
		unset( $_COOKIE[ $name ] );
	}

	public function setCookieTime( $expireDate = "" )
	{
		$this->expire = DateAndTime::getMysqlDateTime( $expireDate );
	}

	public function getCookieParams()
	{
		$returnData = [
			"name"     => $this->name,
			"value"    => $this->value,
			"expire"   => $this->expire,
			"path"     => $this->path,
			"domain"   => $this->domain,
			"secure"   => $this->secure,
			"httpOnly" => $this->httpOnly
		];

		return $returnData;
	}
}