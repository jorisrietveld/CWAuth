<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 2-10-15 - 21:36
 */

namespace CWAuth;

use CWAuth\Models\Authentication\Login;
use CWAuth\Models\Authentication\Logout;
use CWAuth\Models\Authentication\Register;
use CWAuth\Models\Authentication\RememberMeCookie;
use CWAuth\Models\Storage\Session;
use CWAuth\Models\Storage\UserTable;


class Authentication
{
	public    $sessionModel;
	protected $loginModel;
	protected $logoutModel;
	protected $rememberMeModel;

	/**
	 * Save the login, logout and rememberMeCookie model to the classes property's.
	 */
	public function __construct()
	{
		$this->loginModel  = new Login();
		$this->logoutModel = new Logout();
		$this->rememberMeModel  = new RememberMeCookie();
		$this->sessionModel = new Session();

	}

	/**
	 * Attempt to authenticate an user with the credentials passed in the arguments.
	 *
	 * @param            $username
	 * @param            $password
	 * @param bool|false $remember
	 * @return bool
	 */
	public function login( $username, $password, $remember = false )
	{
		return $this->loginModel->attemptAuthenticate( $username, $password, $remember );
	}

	/**
	 * Destroy the session and unset the rememberMeCookie cookie.
	 */
	public function logout()
	{
		$this->logoutModel->deAuthenticateUser();
	}

	/**
	 * Check if the remember me cookie is valid. If it is valid update the expire date and value hash.
	 * It returns
	 *
	 * @return bool
	 */
	public function checkRememberMeCookie()
	{
		$checkResult = ( $this->rememberMeModel->checkRememberMeCookie() ) ? true : false;

		return $checkResult;
	}

	/**
	 * Check whether the user is authenticated. Also check if there is an remember me cookie, if so authenticate
	 * the user with the remember me cookie and return an boolean.
	 *
	 * @return bool
	 */
	public function isAuthenticated()
	{
		$isAuthenticated = $this->loginModel->checkIfLoggedIn();

		return $isAuthenticated;
	}

	/**
	 * Return the user record
	 *
	 * @return array|bool
	 */
	public function getUserData()
	{
		return $this->loginModel->getUserData();
	}

	/**
	 * Get an array with feedback.
	 *
	 * @return array
	 */
	public function getFeedback()
	{
		return $this->loginModel->getFeedback();
	}
}