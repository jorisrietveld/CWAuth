<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 26-10-15 - 14:31
 */

namespace CWAuth\Models\Storage;

class RememberTable
{
	const TABLE = "remember";

	private $allFields = [ ];

	protected $authenticationDatabase;

	public function __construct()
	{
		$authModel                    = new AuthenticationDatabase();
		$this->authenticationDatabase = $authModel->getConnection();
	}

	public function getRememberByUserId( $userId )
	{
		$whereClause = [ "id = :id", [ ":id" => $userId ] ];

		$pdoStatementObj = $this->authenticationDatabase->select( self::TABLE, $this->allFields, $whereClause );

		$resultSet = $pdoStatementObj->fetchAll( \PDO::FETCH_ASSOC );

		// If there is a remember record found.
		if( count( $resultSet ) )
		{
			return $resultSet[ 0 ];
		}

		return false;

	}

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

	public function getRememberByTokenFilterDate( $token, $maxDate )
	{
		$whereClause = [
			"token = :token AND active = 1 AND date < :date ",
			[
				":token" => $token,
				":date"  => $maxDate
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
			"user_id"     => $userId,
			"expires"     => $expires,
			"token"       => $token,
			"active"      => 1,
			"browserInfo" => $browserInfo
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
}