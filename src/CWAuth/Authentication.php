<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 2-10-15 - 21:36
 */

namespace CWAuth;

use CWAuth\Models\Authentication\Login;
use CWAuth\Models\Authentication\Logout;
use CWAuth\Models\Storage\Session;
use CWAuth\Models\Storage\UserTable;


class Authentication
{
    public $sessionModel;
    protected $loginModel;
    protected $logoutModel;

    /**
     * Start the session.
     */
    public function __construct(  )
    {
        $this->sessionModel = new Session();
        $this->loginModel = new Login();
        $this->logoutModel = new Logout();
    }

    /**
     * Return
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

    public function isAuthenticated()
    {
        return $this->loginModel->checkIfLoggedIn();
    }

    public function getUserData()
    {
        return Session::getAllAuthenticationData();
    }

    public function getFeedback(  )
    {
        return $this->loginModel->getFeedback();
    }
}