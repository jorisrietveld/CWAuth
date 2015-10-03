<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 11:36
 * Licence: GPLv3
 */

namespace CWAuth;

class User
{
	protected $id;
	protected $username;
	protected $email;

	public function login( $username, $password )
	{
	}

	public function logout()
	{

	}

	public function register( $username, $password, $email, $applications = [] )
	{

	}

	public function isAuthenticated()
	{

	}

	public function getUsername()
	{

	}

	public function getId()
	{
		
	}

	public function sendRecoverMail( $email )
	{
		
	}

	public function recoverPassword( $token, $password )
	{

	}

	public function setActive()
	{

	}

	public function setPassword( $password )
	{
		
	}

	public function setUsername( $username )
	{
		
	}
}