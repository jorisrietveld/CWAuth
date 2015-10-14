<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 12-10-15 - 21:57
 */

namespace CWAuth\Models\Storage;

use CWAuth\Models\Storage\AuthenticationDatabase;


class UserTable
{
	const TABLE = "users";

	protected $allFields = [ "username", "email", "password", "active" ];
	protected $authenticationDatabase;

	public function __construct()
	{
		$authModel                    = new AuthenticationDatabase();
		$this->authenticationDatabase = $authModel->getConnection();
	}

	/**
	 * The data argument expects an array like ["fieldName" => "value"]
	 *
	 * @param array $data
	 */
	public function registerUser( Array $data )
	{
		$data[ "active" ] = 1;

		$insertedRows = $this->authenticationDatabase->insert( self::TABLE, $data );

		return $insertedRows;
	}

	public function deleteUser( $userId )
	{
		$deletedRows = $this->authenticationDatabase->delete( self::TABLE, $userId );

		return $deletedRows;
	}

	public function blockUser( $userId )
	{
		$updateSetData = [ "active" => 0 ];
		$updateRows    = $this->authenticationDatabase->update( self::TABLE, $updateSetData, $userId );

		return $updateRows;
	}

	public function unBlockUser( $userId )
	{
		$updateSetData = [ "active" => 1 ];
		$updateRows    = $this->authenticationDatabase->update( self::TABLE, $updateSetData, $userId );

		return $updateRows;
	}

	// Get single user
	public function getUserById( $userId )
	{
		$whereClause     = [ "id = :id", [ ":id" => $userId ] ];
		$limitHack       = "id DESC LIMIT 1";
		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause . $limitHack );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is an user found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	public function getUserByEmail( $email )
	{
		$whereClause     = [ "email = :email", [ ":email" => $email ] ];
		$limitHack       = "id DESC LIMIT 1";
		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause . $limitHack );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is an user found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	// get multiple users
	public function getActiveUsers()
	{
		$whereClause     = [ "active = :active", [ ":active" => 1 ] ];
		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		return $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );
	}

	public function getInactiveUsers()
	{
		$whereClause     = [ "active = :active", [ ":active" => 0 ] ];
		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		return $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );
	}

	public function getUsers()
	{
		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields );

		return $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );
	}

	public function getUsersWhere( $where )
	{
		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $where );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is an user found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	// Update user data
	public function updatePassword( $id, $password )
	{
		$updatedRows = $this->authenticationDatabase->update( self::TABLE, [ "password" => $password ], $id );

		return $updatedRows;
	}

	public function updateUsername( $id, $username )
	{
		$updatedRows = $this->authenticationDatabase->update( self::TABLE, [ "username" => $username ], $id );

		return $updatedRows;
	}

	public function updateEmail( $id, $email )
	{
		$updatedRows = $this->authenticationDatabase->update( self::TABLE, [ "email" => $email ], $id );

		return $updatedRows;
	}
}