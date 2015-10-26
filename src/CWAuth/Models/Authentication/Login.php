<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 19:10
 * Licence: GPLv3
 */

namespace CWAuth\Models\Authentication;

use CWAuth\Helper\DateAndTime;
use CWAuth\Helper\Message;
use \CWAuth\Models\Storage\AuthenticationDatabase;
use CWAuth\Models\Storage\Cookie;
use CWAuth\Models\Storage\RecoveryTable;
use CWAuth\Models\Storage\Session;
use CWAuth\Models\Storage\UserTable;


class Login
{
	CONST REMEMBER_ME_TIME        = "+30 days";
	const REMEMBER_ME_COOKIE_NAME = "CWR";

	protected $userTable;
	protected $feedback;
	public    $passwordAutoRehash = true;

	public function __construct()
	{
		$this->userTable = new UserTable();
	}

	public function attemptAuthenticate( $username, $password, $rememberMe = false )
	{
		if( $this->checkIfLoggedIn() )
		{
			return true;
		}

		$userRecord = $this->userTable->getUserByUsername( $username );

		if( $userRecord )
		{
			if( !$this->checkPassword( $password, $userRecord ) )
			{
				$this->setFeedback( "login.feedback.passwordMisMatch" );
			}

			$this->writeToSession( $userRecord[ "id" ], $userRecord[ "username" ] );

			if( $rememberMe )
			{

				//todo write code to implement rememberme
				$this->setRememberMeCookie();
			}

			return true;
		}
		else
		{
			$this->setFeedback( Message::getMessage( "login.feedback.userNotFound", [ "username" => $username ] ) );
		}

		return false;
	}

	protected function writeToSession( $userId, $username )
	{
		//Session::regenerateId();
		Session::setAuthenticationData( [ "userId" => $userId, "username" => $username ] );
	}

	//return boolean
	public function authenticateWithCookie()
	{
		if( isset( $_COOKIE[ self::REMEMBER_ME_COOKIE_NAME ] ) )
		{
			
		}
	}

	public function checkCookie( $cookieValue )
	{
		$expireDate = DateAndTime::ConvertToMysqlDateTime( self::REMEMBER_ME_TIME );

		$recoverTableModel = new RecoveryTable();

		$recoveryRecord = $recoverTableModel->getRecoveryByTokenFilterDate( $cookieValue, $expireDate );

		if( $recoveryRecord )
		{

		}
	}

	protected function setRememberMeCookie( $userId )
	{
		// Generate an hash with an random seed that will be the unique identifier for the user.
		$cookieHash = md5( RandomGenerator::getRandomBytes( 30 ) );
		$cookie     = new Cookie();

		$cookie->setCookieTime( self::REMEMBER_ME_TIME );
		$cookie->writeCookie( self::REMEMBER_ME_COOKIE_NAME, $cookieHash );
		// Get the parameters used to write the cookie so we can grab the expire date.
		$cookieParams = $cookie->getCookieParams();

		$this->saveRememberCookie( $cookieHash, $userId, $cookieParams[ "expire" ] );
	}

	private function saveRememberCookie( $value, $userId, $expire )
	{
		$passwordModel = new Password();
		$cookieHash    = $passwordModel->passwordHash( $value );

		$recoverTableModel = new RecoveryTable();

		if( !$recoverTableModel->insertRecoveryToken( $userId, $cookieHash, $expire ) )
		{
			$logout = new Logout();
			$logout->deleteCookie();
		}
	}

	public function checkIfLoggedIn()
	{
		if( Session::getAuthenticationData( "userId" ) )
		{
			return true;
		}

		return false;
	}

	/**
	 * Check if the entered password corresponds to the password saved in the database. It will also check if the
	 * password needs to be rehashed if so it will rehash the password and update it in the database.
	 *
	 * @param $user
	 * @param $hash
	 * @return bool
	 */
	protected function checkPassword( $password, $userRecord )
	{
		$passwordModel = new Password();

		if( $passwordModel->passwordCheck( $password, $userRecord[ "password" ] ) )
		{
			if( $passwordModel->passwordNeedsRehash( $userRecord[ "password" ], $password ) )
			{
				// Check if the password needs an rehash, if so rehash the password and store it in the database.
				$newHash = $passwordModel->passwordHash( $password );
				if( !$this->userTable->updatePassword( $userRecord[ "id" ], $newHash ) )
				{
					throw new \Exception( Message::getMessage( "login.exceptions.cantUpdatePassword" ) );
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Get feedback.
	 *
	 * @return array
	 */
	public function getFeedback()
	{
		return $this->feedback;
	}

	/**
	 * Set feedback.
	 *
	 * @param $feedback
	 */
	protected function setFeedback( $feedback )
	{
		$this->feedback = $feedback;
	}
}