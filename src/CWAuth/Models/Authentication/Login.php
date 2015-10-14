<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 19:10
 * Licence: GPLv3
 */

namespace CWAuth\Models\Authentication;

use \CWAuth\Models\Storage\AuthenticationDatabase;


class Login
{
	protected $authenticationDatabase;

	public function __construct(  )
	{
		$this->authenticationDatabase = new \CWAuth\Models\Storage\AuthenticationDatabase();
	}

	public function attemptLogin( $username, $password, $rememberMe = false )
	{
		// todo check if blocked.

		$user = $this->userModel->getByUsername( $username );

		if( $user == false )
		{
			return $this->getFeedback();
		}

		if( !( $this->checkPassword( $password, $user[ "password" ] ) ) )
		{
			return $this->getFeedback();
		}

		if( $rememberMe )
		{

		}

		return true;
	}

	/**
	 * Get the user from the database based on the userName.
	 *
	 * @param $username
	 *
	 * @return bool
	 */
	protected function getUserData( $username )
	{
		$user = $this->userModel->getByUsername( $username );

		if( count( $user ) )
		{
			return $user[ 0 ];
		}
		else
		{
			$this->setFeedback( Message::getMessage( "authentication.feedback.userNotFound" ) );

			return false;
		}
	}

	/**
	 * Check if the entered password corresponds to the password saved in the database. It will also check if the
	 * password needs to be rehashed if so it will rehash the password and update it in the database.
	 *
	 * @param $user
	 * @param $hash
	 *
	 * @return bool
	 */
	protected function checkPassword( $user, $hash )
	{
		if( $this->passwordModel->passwordCheck( $user[ "password" ], $hash ) )
		{
			// If the password needs to be rehashed update the password in the database.
			if( $this->passwordModel->passwordNeedsRehash( $hash, $user[ "password" ] ) )
			{
				$newPassword = $this->passwordModel->passwordHash( $user[ "password" ] );
				$this->userModel->updatePassword( $user[ "id" ], $newPassword );
			}

			return true;
		}
		$this->setFeedback( Message::getMessage( "authentication.feedback.passwordMisMatch" ) );

		return false;
	}

	/**
	 * Get feedback.
	 * @return array
	 */
	protected function getFeedback()
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

	protected function saveLogin( $userid )
	{

	}

	protected function logBadAttempt()
	{

	}

}