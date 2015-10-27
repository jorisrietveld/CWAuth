<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 27-10-15 - 13:53
 */

namespace CWAuth\Models\Authentication;

use CWAuth\Models\Storage\RememberTable;
use CWAuth\Models\Storage\UserTable;
use CWAuth\Helper\DateAndTime;
use CWAuth\Models\Storage\Cookie;


class RememberMeCookie
{
	CONST REMEMBER_ME_TIME        = "+30 days";
	CONST REMEMBER_ME_COOKIE_NAME = "CWR";

	protected $userTable;
	protected $rememberTable;

	protected $feedback;

	public function __construct()
	{
		$this->userTable     = new UserTable();
		$this->rememberTable = new RememberTable();
	}

	public function checkRememberMeCookie()
	{
		if( isset( $_COOKIE[ self::REMEMBER_ME_COOKIE_NAME ] ) )
		{
			$currentTime = DateAndTime::ConvertToMysqlDateTime( "now" );
			$cookieValue = $_COOKIE[ self::REMEMBER_ME_COOKIE_NAME ];

			$rememberRecord = $this->rememberTable->getRememberByTokenFilterDate( $cookieValue, $currentTime );

			// If the cookie is found and has not expired and the user didn't switch the user agent.
			if( $rememberRecord )
			{
				// Check if the user is using the same useragent, if not it could be cookie theft.
				if( !$rememberRecord[ "browser_info" ] == $_SERVER[ "HTTP_USER_AGENT" ] )
				{
					//todo Delete the remember me record.
					return false;
				}

				return true;
			}
		}

		return false;
	}

	public function setAnRememberMeCookie( $userId )
	{
		// Generate an hash with an random seed that will be the unique identifier for the user.
		$cookieValue = md5( RandomGenerator::getRandomBytes( 30 ) );
		$cookie      = new Cookie();

		// Set the expire time for the cookie and send it to the user.
		$cookie->setCookieTime( self::REMEMBER_ME_TIME );
		$cookie->writeCookie( self::REMEMBER_ME_COOKIE_NAME, $cookieValue );

		// Get the parameters used to write the cookie so we can grab the expire date.
		$cookieParams = $cookie->getCookieParams();

		$this->saveAnRememberCookieToTheDatabase( $cookieValue, $userId, $cookieParams[ "expire" ] );
	}

	protected function saveAnRememberCookieToTheDatabase( $cookieValue, $userId, $expireDate )
	{
		// Hash the cookie value so if the database is compromised no cookie values are exposed.
		$cookieHash = ( new Password() )->passwordHash( $cookieValue );

		$browserInformation = $_SERVER[ "HTTP_USER_AGENT" ];

		if( !$this->rememberTable->insertRememberToken( $userId, $cookieHash, $expireDate, $browserInformation ) )
		{
			//todo Debug: log error event.
		}
	}

	/**
	 * This method can be called when an user logs in with an remember me cookie. It will delete the old cookie
	 * and update it with an new one.
	 */
	protected function updateAnRememberMeCookie( $cookieId )
	{
		$this->rememberTable->
	}

	public function deleteAnRememberMeCookie()
	{

	}

	private function insertUserIdInCookieValue( $userId, $cookieValue )
	{
		return $cookieValue . "||{$userId}";
	}

	private function extractUserIdFromCookieValue( $cookieValue )
	{
		$segments = explode( "||", $cookieValue );

		if( count( $segments ) == 2 )
		{
			if( is_numeric( $segments[ 1 ] ) )
			{
				return $segments[1];
			}
		}
		return false;
	}
}