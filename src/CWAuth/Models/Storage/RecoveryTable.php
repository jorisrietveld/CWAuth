<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 14-10-15 - 14:05
 */

namespace CWAuth\Models\Storage;

use DebugBar\StandardDebugBar;


class RecoveryTable
{
	const TABLE = "recovery";

	private $allFields = [
		"id",
		"user_id",
		"token",
		"expires",
		"active"
	];

	protected $authenticationDatabase;

	public function __construct()
	{
		$authModel                    = new AuthenticationDatabase();
		$this->authenticationDatabase = $authModel->getConnection();
	}

	public function getRecoveryByUserId( $userId )
	{
		$whereClause = [
			"user_id = :id AND active = 1",
			[
				":id" => $userId
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is an user found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;

	}

	public function getRecoveryById( $userId )
	{
		$whereClause = [
			"id = :id AND active = 1",
			[
				":id" => $userId
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is an user found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;

	}

	public function getRecoveryByToken( $token )
	{
		$whereClause = [
			"token = :token AND active = 1",
			[
				":token" => $token
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is an user found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	public function getRecoveryByTokenFilterDate( $token, $maxDate )
	{
		$whereClause = [
			"token = :token AND active = 1 AND expires > :date ",
			[
				":token" => $token,
				":date"  => $maxDate
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is an user found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	public function insertRecoveryToken( $userId, $token, $expires )
	{
		$insertValues = [
			"user_id"  => $userId,
			"expires" => $expires,
			"token"    => $token,
			"active"   => 1
		];

		return $this->authenticationDatabase->insert( self::TABLE, $insertValues );
	}

	public function deleteRecoveryTokenByToken( $token )
	{
		$dataRecord = $this->getRecoveryByToken( $token );

		if( $dataRecord )
		{
			$setFields = [ "active" => 0 ];
			$id        = $dataRecord[ "id" ];

			return $this->authenticationDatabase->update( self::TABLE, $setFields, $id );
		}

		// debug record not found
		return false;
	}

	public function deleteRecoveryTokenByUserId( $userId )
	{
		$dataRecord = $this->getRecoveryByUserId( $userId );

		if( $dataRecord )
		{
			$setFields = [ "active" => 0 ];
			$id        = $dataRecord[ "id" ];

			return $this->authenticationDatabase->update( self::TABLE, $setFields, $id );
		}

		// debug record not found
		return false;
	}


}