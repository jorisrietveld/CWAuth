<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 11-9-15 - 13:44
 * Licence: GPLv3
 */

namespace CWAuth;

class Authentication
{
	public function __construct(  )
	{

	}

	public function isAuthenticated(  )
	{
		// todo check if the user is authenticated return bool
	}

	public function login( $username, $password, $remember )
	{

	}

	public function logout()
	{

	}

	public function register( $username, $password, $email )
	{

	}

	public function getAuthorizationLevel( $userId )
	{

	}
}