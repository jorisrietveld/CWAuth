<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 3-10-15 - 2:29
 */

namespace CWAuth;

use CWAuth\Models\Authentication\Register;


class UsersManager
{
	public function registerUser( $username, $password, $email )
	{
		$registerModel = new Register();

		return $registerModel->registerUser( $username, $password, $email );
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

	public function getUsers()
	{

	}

	public function getUsersWhere( $where )
	{

	}

	// Update user data
	public function updatePassword( $id, $password )
	{

	}

	public function updateUsername( $id, $username )
	{

	}

	public function updateEmail( $id, $email )
	{

	}
}