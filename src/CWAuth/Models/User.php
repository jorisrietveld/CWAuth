<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 15-9-15 - 14:17
 * Licence: GPLv3
 */

namespace CWAuth\Models;

use PDO;


class User
{
	CONST DATABASE   = "CampusWerk";
	CONST USER_TEBLE = "users";

	protected $databaseConnection;

	public function __construct()
	{
		$databaseModel            = new Database();
		$this->databaseConnection = $databaseModel->getDatabaseConnection();
	}

	public function getByUsername( $username )
	{
		$bindValues = [ $username => PDO::PARAM_STR ];

		return $this->getData( " WHERE `username` = ?;", $bindValues );
	}

	public function getById( $id )
	{
		$bindValues = [ $id => PDO::PARAM_INT ];

		return $this->getData( " WHERE `id` = ?;" );
	}

	public function getByEmail( $email )
	{
		$bindValues = [ $email => PDO::PARAM_STR ];

		return $this->getData( " WHERE `email` = ? ", $bindValues );
	}

	public function updatePassword( $id, $password )
	{

	}

	public function updateEmail( $id, $email )
	{

	}

	public function updateUsername( $id, $userName )
	{
		$bindValues = [ $userName => PDO::PARAM_STR, $id => PDO::PARAM_INT ];

		return $this->updateData( "username = ? ", $bindValues );
	}

	public function updateData( $sql, $params )
	{
		$sql = "UPDATE " . self::DATABASE . "." . self::USER_TEBLE . " SET " . $sql . " WHERE id = ?";

		$preparedStatement = $this->databaseConnection->prepare( $sql );
		$counter           = 1;

		foreach( $params as $param => $paramType )
		{
			$preparedStatement->bindValue( $counter, $param, $paramType );
			$counter++;
		}
	}

	public function getData( $sql, $params )
	{
		$sql = "SELECT `username`, `password`, `email` FROM " . self::DATABASE . "." . self::USER_TEBLE . $sql;

		$preparedStatement = $this->databaseConnection->prepare( $sql );
		$counter           = 1;

		foreach( $params as $param => $paramType )
		{
			$preparedStatement->bindValue( $counter, $param, $paramType );
			$counter++;
		}

		$preparedStatement->execute();

		return $preparedStatement->fetchAll( PDO::FETCH_ASSOC );
	}
}