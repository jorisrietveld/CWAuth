<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 26-10-15 - 14:31
 */

namespace CWAuth\Models\Storage;

class RememberTable
{
	const TABLE = "remember";

	private $allFields = [
		"id",
		"user_id",
		"token",
		"expires",
		"browser_info",
		"active"
	];

	protected $authenticationDatabase;
	protected $authenticationModel;

	public function __construct( $enableQueryLogger = false )
	{
		$this->authenticationModel = new AuthenticationDatabase();
		$this->authenticationDatabase = $this->authenticationModel->getConnection();
		$this->authenticationDatabase->logQuerys = $enableQueryLogger;
	}

	/**
	 * Search for an record from the remember table by user id.
	 *
	 * @param $userId
	 * @return bool
	 */
	public function getRememberByUserId( $userId )
	{
		$whereClause = [
			"user_id = :userId AND active = 1",
			[
				":userId" => $userId
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	public function getRememberByUserIdFilterDate( $userId, $currentDate )
	{
		$whereClause = [
			"user_id = :userId AND active = 1 AND :currentDate < expires",
			[
				":userId"      => $userId,
				":currentDate" => $currentDate
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	/**
	 * Search for an record from the remember table by its id.
	 *
	 * @param $recordId
	 * @return bool
	 */
	public function getRememberById( $recordId )
	{
		$whereClause = [
			"id = :id AND active = 1",
			[
				":id" => $recordId
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	/**
	 * Search for an record form the remember table by token.
	 *
	 * @param $token
	 * @return bool
	 */
	public function getRememberByToken( $token )
	{
		$whereClause = [
			"token = :token AND active = 1",
			[
				":token" => $token
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is a remember record found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	public function getRememberByTokenFilterDate( $token, $currentDate )
	{
		$whereClause = [
			"token = :token AND active = 1 AND expires < :currentDate ",
			[
				":token"       => $token,
				":currentDate" => $currentDate
			]
		];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		/// If there is a remember record found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;
	}

	public function insertRememberToken( $userId, $token, $expires, $browserInfo )
	{
		$insertValues = [
			"user_id"      => $userId,
			"expires"      => $expires,
			"token"        => $token,
			"active"       => 1,
			"browser_info" => $browserInfo
		];

		return $this->authenticationDatabase->insert( self::TABLE, $insertValues );
	}

	public function deleteRememberTokenByToken( $token )
	{
		$dataRecord = $this->getRememberByToken( $token );

		if( $dataRecord )
		{
			$setFields = [ "active" => 0 ];
			$id        = $dataRecord[ "id" ];

			return $this->authenticationDatabase->update( self::TABLE, $setFields, $id );
		}

		// debug record not found
		return false;
	}

	public function deleteRememberTokenByUserId( $userId )
	{
		$dataRecord = $this->getRememberByUserId( $userId );

		if( $dataRecord )
		{
			$setFields = [ "active" => 0 ];
			$id        = $dataRecord[ "id" ];

			return $this->authenticationDatabase->update( self::TABLE, $setFields, $id );
		}

		// debug record not found
		return false;
	}

	public function deleteRememberTokenById( $Id )
	{
		$dataRecord = $this->getRememberById( $Id );

		if( $dataRecord )
		{
			$setFields = [
				"active" => 0
			];

			$id = $dataRecord[ "id" ];

			return $this->authenticationDatabase->update( self::TABLE, $setFields, $id );
		}

		// debug record not found
		return false;
	}

	public function updateRememberRecordById( $recordId, $newToken, $newExpireDate )
	{
		$dataRecord = $this->getRememberById( $recordId );

		if( $dataRecord )
		{
			$setFields = [
				"token"  => $newToken,
				"expires" => $newExpireDate
			];

			return $this->authenticationDatabase->update( self::TABLE, $setFields, $recordId );
		}

		// debug record not found
		return false;
	}

	public function getAllQuerys(  )
	{
		return $this->authenticationDatabase->getAllQuerys();
	}
}