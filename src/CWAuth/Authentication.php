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
	protected $rememberMe;

	/**
	 * Start the session.
	 */
	public function __construct()
	{
		$this->loginModel  = new Login();
		$this->logoutModel = new Logout();
		$this->rememberMe = new RememberMeCookie();
	}

	/**
	 * Return
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


	public function logout()
	{
		$this->logoutModel->deAuthenticateUser();
	}

	public function checkRememberMeCookie()
	{
		return $this->rememberMe->checkRememberMeCookie();
	}

	public function isAuthenticated()
	{
		$isAuthenticated = $this->loginModel->checkIfLoggedIn();

		return $isAuthenticated;
	}

	public function getUserData()
	{
		//todo remove hack.

		$this->loginModel->getUserData();
		if( isset( $_SESSION[ "authentication" ][ "username" ] ) && isset( $_SESSION[ "authentication" ][ "userId" ] ) )
		{
			return $_SESSION[ "authentication" ];
		}
	}

	public function getFeedback()
	{
		return $this->loginModel->getFeedback();
	}
}