<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 15-9-15 - 14:17
 * Licence: GPLv3
 */

namespace CWAuth\Models;

class User
{
	protected $databaseConnection;

	public function __construct(  )
	{
        $this->databaseConnection = new Database();
	}
	
	public function getByUsername( $username )
	{
		//TODO return user by username
	}

	public function getById( $id )
	{
		// todo write code to return an user by id.
	}

	public function getByEmail( $email )
	{
		// todo write code to return an user by email
	}

	public function updatePassword( $id, $password )
	{
		
	}

	public function updateEmail( $id, $email )
	{

	}

	public function updateUsername( $id, $email )
	{

	}
}