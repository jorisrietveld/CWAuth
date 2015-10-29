<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 29-10-15 - 13:47
 */

namespace CWAuth\Models\Authentication;

use CWAuth\Models\Storage\UserTable;


class UsersManager
{
	protected $userTable;
	protected $errors = [ ];

	public function __construct()
	{
		$this->userTable = new UserTable();
	}

	public function getActiveUsers()
	{
		try
		{
			$activeUsers = $this->userTable->getActiveUsers();

			return $activeUsers;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	public function getInactiveUsers()
	{
		try
		{
			$inactiveUsers = $this->userTable->getInactiveUsers();

			return $inactiveUsers;
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}

	}

	public function getUsers()
	{
		try
		{
			return $this->userTable->getUsers();
		}
		catch( \Exception $exception )
		{
			//TODO log exception.
			$this->setErrorMessage( $exception->getMessage() );

			return false;
		}
	}

	public function getUsersWhere( Array $where )
	{
		try
		{
			$users = $this->userTable->getUsersWhere( $where );
			return $users;
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
		$this->errors[] = $errorMessage;
	}
}