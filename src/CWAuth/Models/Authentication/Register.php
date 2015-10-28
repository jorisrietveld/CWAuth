<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 12-10-15 - 21:41
 */

namespace CWAuth\Models\Authentication;

use CWAuth\Models\Storage\UserTable;


class Register
{
	private $userTable;

	public function __construct()
	{
		$this->userTable = new UserTable();
	}

	public function registerUser( $username, $password, $email )
	{
		$passwordHash = $this->getPasswordHash( $password );

		$registerData = [
			"username" => $username,
			"password" => $passwordHash,
			"email"    => $email
		];

		if( $this->userTable->registerUser( $registerData ) )
		{
			// the user is registered.
			return true;
		}
		else
		{
			// todo debug: the user couldn't be resisted.
			return false;
		}
	}

	protected function getPasswordHash( $password )
	{
		$passwordModel = new Password();
		$passwordHash  = $passwordModel->passwordHash( $password );

		return $passwordHash;
	}
}