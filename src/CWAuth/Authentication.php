<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 2-10-15 - 21:36
 */

namespace CWAuth;

use CWAuth\Models\Authentication\Login;
use CWAuth\Models\Storage\Session;


class Authentication
{
    public function __construct(  )
    {
        $session = new Session();
    }

    public function login( $username, $password, $remember = false )
    {
        $login = new Login();

        $login->attemptAuthenticate( $username, $password, $remember );
    }

    public function logout()
    {

    }

    public function isAuthenticated()
    {

    }

    public function getUserData()
    {

    }
}