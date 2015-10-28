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
	protected $cookie;

	protected $feedback;

	public function __construct()
	{
		$this->userTable     = new UserTable();
		$this->rememberTable = new RememberTable();
		$this->cookie = new Cookie();
	}

	public function checkRememberMeCookie()
	{
		if( isset( $_COOKIE[ self::REMEMBER_ME_COOKIE_NAME ] ) )
		{
			$currentTime = DateAndTime::ConvertToMysqlDateTime( "now" );
			$cookieValue = $_COOKIE[ self::REMEMBER_ME_COOKIE_NAME ];

			// Get the token and user id from the cookie value
			$cookieValueSegments = $this->extractDataFromCookieValue( $cookieValue );
			$userId              = $cookieValueSegments[ 1 ];
			$cookieValue         = $cookieValueSegments[ 0 ];

			$rememberRecord = $this->rememberTable->getRememberByUserIdFilterDate( $userId, $currentTime );

			// If the cookie is found and has not expired and the user didn't switch the user agent.
			if( $rememberRecord )
			{
				// Check if the user is using the same useragent, if not it could be cookie theft.
				if( !$rememberRecord[ "browser_info" ] == $_SERVER[ "HTTP_USER_AGENT" ] )
				{
					$this->rememberTable->deleteRememberTokenById( $rememberRecord[ "id" ] );

					return false;
				}
				//return true;
				// todo implement an way to update the cookie
				$this->updateAnRememberMeCookie( $rememberRecord[ "id" ], $rememberRecord["user_id"] );
				return $rememberRecord["user_id"];
			}
		}

		return false;
	}

	public function setAnRememberMeCookie( $userId )
	{
		if( $this->checkRememberMeCookie() )
		{
			// todo debug: log error.
			return;
		}

		// Generate an hash with an random seed that will be the unique identifier for the user.
		$cookieValue = md5( RandomGenerator::getRandomBytes( 30 ) );

		$cookieValue = $this->insertUserIdInCookieValue( $userId, $cookieValue );

		$expireDate = DateAndTime::ConvertToMysqlDateTime( self::REMEMBER_ME_TIME );

		// Set the expire time for the cookie and send it to the user.
		$this->cookie->setCookieTime( $expireDate );

		$this->cookie->writeCookie( self::REMEMBER_ME_COOKIE_NAME, $cookieValue );

		$this->saveAnRememberCookieToTheDatabase( $cookieValue, $userId, $expireDate );
	}

	protected function saveAnRememberCookieToTheDatabase( $cookieValue, $userId, $expireDate )
	{
		$passwordModel = new Password();

		// Hash the cookie value so if the database is compromised no cookie values are exposed.
		$cookieHash = $passwordModel->passwordHash( $cookieValue );

		$browserInformation = $_SERVER[ "HTTP_USER_AGENT" ];

		if( !$this->rememberTable->insertRememberToken( $userId, $cookieHash, $expireDate, $browserInformation ) )
		{
			//todo Debug: log error event.
		}
		else
		{
			//todo Debug: log info event.;

		}
	}

	/**
	 * This method can be called when an user logs in with an remember me cookie. It will delete the old cookie
	 * and update it with an new one.
	 */
	protected function updateAnRememberMeCookie( $rememberRecordId, $userId )
	{
		$newCookieValue = md5( RandomGenerator::getRandomBytes( 30 ) );

		$newCookieValue = $this->insertUserIdInCookieValue( $userId, $newCookieValue );

		$newExpireDate = DateAndTime::ConvertToMysqlDateTime( self::REMEMBER_ME_TIME );

		// Set an new expire time for the cookie and send it to the user.
		$this->cookie->setCookieTime( $newExpireDate );

		$this->cookie->writeCookie( self::REMEMBER_ME_COOKIE_NAME, $newCookieValue );

		$this->rememberTable->updateRememberRecordById( (int)$rememberRecordId, $newCookieValue, $newExpireDate );
	}

	public function deleteAnRememberMeCookie( $user_id )
	{
		$this->rememberTable->deleteRememberTokenByUserId( $user_id );

		$this->cookie->deleteCookie( self::REMEMBER_ME_COOKIE_NAME );
	}

	private function insertUserIdInCookieValue( $userId, $cookieValue )
	{
		return $cookieValue . "||{$userId}";
	}

	public function extractDataFromCookieValue( $cookieValue )
	{
		$segments = explode( "||", $cookieValue );

		if( count( $segments ) == 2 )
		{
			if( is_numeric( $segments[ 1 ] ) )
			{
				return $segments;
			}
		}

		return [ 0, 0 ];
	}
}