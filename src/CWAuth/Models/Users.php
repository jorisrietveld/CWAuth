<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 12-10-15 - 16:13
 */

namespace CWAuth\Models;

class Users
{
	public function registerUser( Array $data )
	{

	}

	public function deleteUser( $userId )
	{

	}

	// Manage
	public function lockUser( $userId )
	{

	}

	public function unlockUser( $userId )
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