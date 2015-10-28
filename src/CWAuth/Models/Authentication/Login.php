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
use CWAuth\Models\Storage\RememberTable;
use CWAuth\Models\Storage\Session;
use CWAuth\Models\Storage\UserTable;


class Login
{
	protected $userTable;
	protected $rememberMe;

	protected $feedback;
	public    $passwordAutoRehash = true;

	public function __construct()
	{
		$this->userTable  = new UserTable();
		$this->rememberMe = new RememberMeCookie();
	}

	/**
	 * Attempt to authenticate an user by user name and password.
	 *
	 * @param            $username
	 * @param            $password
	 * @param bool|false $rememberMe
	 * @return bool
	 * @throws \Exception
	 */
	public function attemptAuthenticate( $username, $password, $rememberMe = false )
	{
		if( $this->checkIfLoggedIn() )
		{
			return true;
		}

		if( $this->rememberMe->checkRememberMeCookie() )
		{
			$rememberMe = $this->rememberMe;
			$valueSegments = $this->rememberMe->extractDataFromCookieValue( $_COOKIE[ $rememberMe::REMEMBER_ME_COOKIE_NAME ] );
			$userId = $valueSegments[1];

			// If it is sure the cookie can be trusted log him in.
			$this->authenticateUserByUserId( $userId );
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
				$this->rememberMe->setAnRememberMeCookie( $userRecord[ "id" ] );
			}

			return true;
		}
		else
		{
			$this->setFeedback( Message::getMessage( "login.feedback.userNotFound", [ "username" => $username ] ) );
		}

		return false;
	}

	/**
	 * Authenticate an user by id without checking anything. Only use this for logging in with an cookie.
	 *
	 * @param $userId
	 */
	public function authenticateUserByUserId( $userId )
	{
		$userRecord = $this->userTable->getUserById( $userId );

		if( $userRecord )
		{
			$this->writeToSession( $userRecord[ "id" ], $userRecord[ "username" ] );
		}
		// debug users could not be found in table.
	}

	/**
	 * This method will write the user id and username the the authentication session.
	 *
	 * @param $userId
	 * @param $username
	 */
	protected function writeToSession( $userId, $username )
	{
		//Session::regenerateId();
		Session::setAuthenticationData( [ "userId" => $userId, "username" => $username ] );
	}

	/**
	 * Check if the authentication session contains an user id.
	 *
	 * @return bool
	 */
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