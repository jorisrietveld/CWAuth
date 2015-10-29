<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 29-10-15 - 13:46
 */

namespace CWAuth\Authentication;

use CWAuth\Helper\Message;
use CWAuth\Models\Authentication\Register;
use CWAuth\Models\Storage\UserTable;


class UserManager
{
	protected $userTableModel;
	protected $registerModel;

	protected $errors   = [ ];
	protected $feedback = [ ];

	public function __construct()
	{
		$this->userTableModel = new UserTable();
		$this->registerModel  = new Register();
	}

	public function registerUser( $username, $password, $email )
	{
		try
		{
			$userRegisterd = $this->registerModel->registerUser( $username, $password, $email );

			if( $userRegisterd )
			{
				return true;
			}

			if( count( $this->registerModel->getFeedback() ) )
			{
				$this->feedback = $this->registerModel->getFeedback();
			}
			else
			{
				$this->setFeedback( Message::getMessage( "userManager.feedback.notRegistered" ) );
			}
			return false;

		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
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

			$this->setFeedback( Message::getMessage( "userManager.feedback.deleteZeroRowCount", [ "id" => $userId ] ) );

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
			$this->setFeedback( Message::getMessage( "userManager.feedback.blockZeroRowCount", [ "id" => $userId ] ) );

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

			$this->setFeedback( Message::getMessage( "userManager.feedback.unBlockZeroRowCount", [ "id" => $userId ] ) );

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
			$this->setFeedback( Message::getMessage( "userManager.feedback.userNotFoundId", [ "id" => $userId ] ) );

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
			$this->setFeedback( Message::getMessage( "userManager.feedback.userNotFoundEmail", [ "email" => $email ] ) );

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

			$this->setFeedback( Message::getMessage( "userManager.feedback.cantUpdatePassword", [ "id" => $userId ] ) );

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
			$this->setFeedback( Message::getMessage( "userManager.feedback.cantUpdateUsername", [ "id" => $userId, "username" => $username ] ) );

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

			$this->setFeedback( Message::getMessage( "userManager.feedback.cantUpdateEmail", [ "id" => $userId, "email" => $email ] ) );

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
		$this->errors[] = trim( $errorMessage );
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