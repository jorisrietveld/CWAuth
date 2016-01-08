<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 12-10-15 - 21:41
 */

namespace CWAuth\Models\Authentication;

use CWAuth\Helper\Message;
use CWAuth\Models\Storage\UserTable;


class Register
{
	private $userTable;

	private $feedback = [ ];

	public function __construct( UserTable $userTable = null )
	{
		$this->userTable = ( $userTable ) ? $userTable : new UserTable();
	}

	public function registerUser( $username, $password, $email )
	{
		$passwordHash = $this->getPasswordHash( $password );

		$registerData = [
			"username" => $username,
			"password" => $passwordHash,
			"email"    => $email
		];

		if( !$this->checkUniqueEmail( $email ) || !$this->checkUniqueUsername( $username ) )
		{
			return false;
		}

		if( $this->userTable->registerUser( $registerData ) )
		{
			// the user is registered.
			return true;
		}
		else
		{
			//var_dump(__METHOD__);
			// todo debug: the user couldn't be resisted.
			return false;
		}
	}


	protected function checkUniqueUsername( $username )
	{
		if( $this->userTable->getUserByUsername( $username ) )
		{
			$this->setFeedback( Message::getMessage( "register.feedback.notUniqueUsername", [ "username" => $username ] ) );

			return false;
		}

		return true;
	}

	protected function checkUniqueEmail( $email )
	{
		if( $this->userTable->getUserByEmail( $email ) )
		{
			$this->setFeedback( Message::getMessage( "register.feedback.notUniqueEmail", [ "email" => $email ] ) );

			return false;
		}

		return true;
	}

	protected function getPasswordHash( $password )
	{
		$passwordModel = new Password();
		$passwordHash  = $passwordModel->passwordHash( $password );

		return $passwordHash;
	}

	/**
	 * Set feedback.
	 *
	 * @param $feedback
	 */
	protected function setFeedback( $feedback )
	{
		$this->feedback[] = $feedback;
	}

	public function getFeedback()
	{
		return $this->feedback;
	}
}