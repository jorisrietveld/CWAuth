<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 3-10-15 - 2:29
 */

namespace CWAuth;

class UsersManager
{
	public function registerUser( Array $data )
	{
		// validate data
	}

	public function deleteUser( $userId )
	{

	}

	public function blockUser( $userId )
	{

	}

	public function unBlockUser( $userId )
	{

	}

	// Get single user
	public function getUserById( $userId )
	{

	}

	public function getUserByEmail( $email )
	{

	}

	// get multiple users
	public function getActiveUsers()
	{

	}

	public function getInactiveUsers()
	{

	}

	public function getUsers( )
	{

	}

	public function getUsersWhere( $where )
	{

	}

	// Update user data
	public function updatePassword( $id, $password )
	{

	}

	public function updateUsername( $id, $username)
	{

	}

	public function updateEmail( $id, $email )
	{

	}
}