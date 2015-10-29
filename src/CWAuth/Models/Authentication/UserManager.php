<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 29-10-15 - 13:46
 */

namespace CWAuth\Models\Authentication;

use CWAuth\Helper\Message;
use CWAuth\Models\Storage\UserTable;


class UserManager
{
	protected $userTableModel;
	protected $errors   = [ ];
	protected $feedback = [ ];

	public function __construct()
	{
		$this->userTableModel = new UserTable();
	}

	public function deleteUser( $userId )
	{
		try
		{
			$userDeleted = $this->userTableModel->deleteUser( $userId );

			if( $userDeleted )
			{
				return true;
			}

			$this->setFeedback( Message::getMessage( "userManager.errorMessages.deleteZeroRowCount", [ "id" => $userId ] ) );

			return false;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	public function blockUser( $userId )
	{
		try
		{
			$userBlocked = $this->userTableModel->blockUser( $userId );

			if( $userBlocked )
			{
				return true;
			}
			$this->setFeedback( Message::getMessage( "userManager.errorMessages.blockZeroRowCount", [ "id" => $userId ] ) );

			return false;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	public function unBlockUser( $userId )
	{
		try
		{
			$userUnBlocked = $this->userTableModel->unBlockUser( $userId );

			if( $userUnBlocked )
			{
				return true;
			}

			$this->setFeedback( Message::getMessage( "userManager.errorMessages.unBlockZeroRowCount", [ "id" => $userId ] ) );

			return false;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	// Get single user
	public function getUserById( $userId )
	{
		try
		{
			$user = $this->userTableModel->getUserById( $userId );

			if( $user )
			{
				return true;
			}
			$this->setFeedback( Message::getMessage( "userManager.errorMessages.userNotFoundId", [ "id" => $userId ] ) );

			return false;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	public function getUserByEmail( $email )
	{
		try
		{
			$user = $this->userTableModel->getUserById( $email );

			if( $user )
			{
				return true;
			}
			$this->setFeedback( Message::getMessage( "userManager.errorMessages.userNotFoundEmail", [ "email" => $email ] ) );

			return false;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	// Update user data
	public function updatePassword( $userId, $password )
	{
		try
		{
			$updatedRows = $this->userTableModel->updatePassword( $userId, $password );

			if( $updatedRows )
			{
				return true;
			}

			$this->setFeedback( Message::getMessage( "userManager.errorMessages.cantUpdatePassword", [ "id" => $userId ] ) );

			return false;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	public function updateUsername( $userId, $username )
	{
		try
		{
			$updatedRows = $this->userTableModel->updateUsername( $userId, $username );

			if( $updatedRows )
			{
				return true;
			}
			$this->setFeedback( Message::getMessage( "userManager.errorMessages.cantUpdateUsername", [ "id" => $userId, "username" => $username ] ) );

			return false;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	public function updateEmail( $userId, $email )
	{
		try
		{
			$updatedRows = $this->userTableModel->updateEmail( $userId, $email );

			if( $updatedRows )
			{
				return true;
			}

			$this->setFeedback( Message::getMessage( "userManager.errorMessages.cantUpdateEmail", [ "id" => $userId, "email" => $email ] ) );

			return false;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	public function getErrors()
	{
		return $this->errors;
	}

	protected function setErrorMessage( $errorMessage )
	{
		$this->errors[] = trim( $errorMessage);
	}

	public function getFeedback()
	{
		return $this->feedback;
	}

	protected function setFeedback( $feedback )
	{
		$this->errors[] = trim( $feedback );
	}
}