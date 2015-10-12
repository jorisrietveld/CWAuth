<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 2-10-15 - 21:53
 */

namespace CWAuth\contracts;

interface UserManager
{
	public function registerUser( Array $data );

	public function deleteUser( $userId );

	// Manage
	public function lockUser( $userId );

	public function unlockUser( $userId );

	public function blockUser( $userId );

	public function unBlockUser( $userId );

	// Get single user
	public function getUserById( $userId );

	public function getUserByEmail( $email );

	// get multiple users
	public function getActiveUsers();

	public function getInactiveUsers();

	public function getUsers( );

	public function getUsersWhere( $where );

	// Password recovery
	public function sendPasswordRecoveryMail( $email );

	public function recoverPassword( $token, $password );

	// Update user data
	public function updatePassword( $id, $password );

	public function updateUsername( $id, $username);

	public function updateEmail( $id, $email );
}