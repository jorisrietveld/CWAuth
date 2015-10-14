<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 2-10-15 - 21:36
 */

namespace CWAuth;

use CWAuth\Models\Authentication\Login;


class Authentication
{
    public function __construct(  )
    {
    }

    public function login( $username, $password, $remember = false )
    {
        $login = new Login();

        $login->attemptLogin( $username, $password, $remember );
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