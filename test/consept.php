<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 3-10-15 - 2:29
 */

require( "header.php" );

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Authentication
 */

$authentication = new CWAuth\Authentication();

/**
 * Authenticate user
 */
if( false )
{
	if( $authentication->isAuthenticated() )
	{
		// user is logged in
		$authentication->getUserData();
	}
	else
	{
		$username   = 'rekcahxunil';
		$password   = 'pa$$w0rd';
		$rememberMe = true;

		$success = $authentication->login( $username, $password, $rememberMe );

		if( $success )
		{
			// user is logged in
		}
		else
		{
			// Authentication failed, get the feedback.
			var_dump( $authentication->getFeedback());
		}
	}
}

/**
 * Deauthenticate user.
 */
if( false )
{
	$authentication->logout();
}

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * User management
 */

$userManager = new \CWAuth\UsersManager();

/**
 * Register user
 */
if( false )
{
	$newUserData = [ "username" => "admin", "password" => "abc123", "email" => "admin@campuswerk.nl" ];

	$success = $userManager->register( $newUserData );

	if( $success )
	{
		// user is registered
	}
	else
	{
		// The user could not be registered, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Delete user
 */

if( false )
{
	$userId = 1;

	$success = $userManager->deleteUser( $userId );

	if( $success )
	{
		// The user is deleted.
	}
	else
	{
		// The user could not be deleted, get the feedback.
		var_dump( $userManager->getFeedback());
	}
}

/**
 * Lock user
 */

if( false )
{
	$userId = 1;

	$success = $userManager->lockUser( $userId );

	if( $success )
	{
		// the user is locked.
	}
	else
	{
		// The user could not de locked, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * UnLock user
 */

if( false )
{
	$userId = 1;

	$success = $userManager->unLockUser( $userId );

	if( $success )
	{
		// the user is unlocked.
	}
	else
	{
		// The user could not de unlocked, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Block user
 */

if( false )
{
	$userId = 1;

	$success = $userManager->blockUser( $userId );

	if( $success )
	{
		// the user is blocked..
	}
	else
	{
		// The user could not de blocked, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Un block user
 */

if( false )
{
	$userId = 1;

	$success = $userManager->unBlockUser( $userId );

	if( $success )
	{
		// the user is un blocked..
	}
	else
	{
		// The user could not de un blocked, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Password recovery
 */

/**
 * Send password recovery email
 */

if( false )
{
	$success = $userManager->sendPasswordRecoveryMail( $userId );

	if( $success )
	{
		// the password recovery mail is send
	}
	else
	{
		// The password recovery mail is not send, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Update the users password for password recovery.
 */

if( false )
{
	$success = $userManager->recoverPassword( $token, $password );

	if( $success )
	{
		// the password is successfully updated.
	}
	else
	{
		// The password recovery failed, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Get multiple users
 */

/**
 * Get all users
 */

if( false )
{
	$users = $userManager->getUsers();

	if( $users )
	{
		// all users
	}
	else
	{
		// Could not get all the users, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Get all active users
 */

if( false )
{
	$users = $userManager->getActiveUsers();

	if( $users )
	{
		// all users active users.
	}
	else
	{
		// Could not get all the users, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Get all inactive users.
 */

if( false )
{
	$users = $userManager->getInctiveUsers();

	if( $users )
	{
		// all users inactive users.
	}
	else
	{
		// Could not get all the users, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Get users based on an where clause condition
 */

if( false )
{
	$boundValues = [ 1, 1 ];
	$whereClause = [ "active = ? AND id = ? ", $boundValues ];

	$users = $userManager->getUsersWhere( $whereClause );

	if( $users )
	{
		if( count( $users ))
		{
			// There where users found.
		}
		else
		{
			// no users where found.
		}
	}
	else
	{
		// Could not get all the users filtered by the where clause.
		var_dump( $userManager->getFeedback() );
	}
}

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Get single user
 */

/**
 * Get user by id
 */

if( false )
{
	$userId = 1;

	$user = $userManager->getUserById( $userId );

	if( $user )
	{
		// The user was found.
	}
	else
	{
		// Could not get the user,get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Get user by email
 */

if( false )
{
	$email = "snowden@nsa.gov";

	$user = $userManager->getUserByEmail( $email );

	if( $user )
	{
		// The user was found.
	}
	else
	{
		// Could not get the user, get the feedback.
		var_dump( $userManager->getFeedback() );
	}
}

/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Update user data
 */

/**
 * Update username
 */

if( false )
{
	$userId = 1;
	$newUsername = "newUsername";

	$success = $userManager->updateUsername( $userId, $newUsername );

	if( $success )
	{
		// The username was updated.
	}
	else
	{
		// Could not update the username.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Update password
 */

if( false )
{
	$userid = 1;
	$newPassword = "newPassword";

	$success = $userManager->updatePassword( $userid, $newPassword );

	if( $success )
	{
		// The password was successfully updated.
	}
	else
	{
		// Could not update the password.
		var_dump( $userManager->getFeedback() );
	}
}

/**
 * Update email address
 */

if( false )
{
	$userId = 1;
	$newEmail = "lulz@nsa.gov";

	$success = $userManager->updateEmail( $userId, $newEmail );

	if( $success )
	{
		// The email address was successfully updated.
	}
	else
	{
		// Could not update the email address, get feedback.
		var_dump( $userManager->getFeedback() );
	}
}