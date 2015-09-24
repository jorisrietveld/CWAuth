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
	// This constant holds the default name of the database to connect to.
	CONST DATABASE   = "CampusWerk";

	// This constant holds the default name of the table to connect to.
	CONST USER_TABLE = "users";

	// This wil hold an php data object (PDO).
	protected $databaseConnection;

	// This property is the full name of the database.table to connect to.
	protected $tableName = self::DATABASE . "." . self::USER_TABLE;

	/**
	 * initialize the user model by saving an database connection to the databaseConnection property.
	 */
	public function __construct()
	{
		$databaseModel            = new Database();
		$this->databaseConnection = $databaseModel->getDatabaseConnection();
	}

	/**
	 * This method returns an database record with all users with the username given by the argument or false
	 * if the username is not found in the database.
	 *
	 * @param $username
	 *
	 * @return mixed
	 */
	public function getByUsername( $username )
	{
		$bindValues = [ $username => PDO::PARAM_STR ];

		return $this->getData( " WHERE `username` = ?;", $bindValues );
	}

	/**
	 * This method returns an database record with all users with the id given by the argument or false
	 * if the id is not found in the database.
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getById( $id )
	{
		$bindValues = [ $id => PDO::PARAM_INT ];

		return $this->getData( " WHERE `id` = ?;", $bindValues );
	}

	/**
	 * This method returns an database record with all users with the email given by the argument or false
	 * if the email is not found in the database.
	 * @param $email
	 *
	 * @return mixed
	 */
	public function getByEmail( $email )
	{
		$bindValues = [ $email => PDO::PARAM_STR ];

		return $this->getData( " WHERE `email` = ? ", $bindValues );
	}

	/**
	 * This method updates an password field from an record with the id from the argument passed. It returns an boolean
	 * based on the result of the success of the query.
	 *
	 * @param $id
	 * @param $password
	 *
	 * @return mixed
	 */
	public function updatePassword( $id, $password )
	{
		$bindValues = [ $password => PDO::PARAM_STR, $id => PDO::PARAM_INT ];

		return $this->updateData( "password = ? ", $bindValues );
	}

	/**
	 * This method updates an email field from an record with the id from the argument passed. It returns an boolean
	 * based on the result of the success of the query.
	 *
	 * @param $id
	 * @param $email
	 *
	 * @return mixed
	 */
	public function updateEmail( $id, $email )
	{
		$bindValues = [ $email => PDO::PARAM_STR, $id => PDO::PARAM_INT ];

		return $this->updateData( " email = ? ", $bindValues );
	}

	/**
	 * This method updates an username field from an record with the id from the argument passed. It returns an boolean
	 * based on the result of the success of the query.
	 *
	 * @param $id
	 * @param $userName
	 *
	 * @return mixed
	 */
	public function updateUsername( $id, $userName )
	{
		$bindValues = [ $userName => PDO::PARAM_STR, $id => PDO::PARAM_INT ];

		return $this->updateData( "username = ? ", $bindValues );
	}

	/**
	 * This will insert an user in the database and will return an boolean based on the success of the query.
	 *
	 * @param $username
	 * @param $password
	 * @param $email
	 *
	 * @return mixed
	 */
	public function insertUser( $username, $password, $email )
	{
		$sql        = "INSERT INTO {$this->tableName} (`email`, `username`, `password`) VALUES ( :email, :username, :password );";
		$bindValues = [ ":email" => $email, ":username" => $username, ":password" => $password ];

		$preparedStatment = $this->databaseConnection->prepare( $sql );

		return $preparedStatment->execute( $bindValues );
	}

	/**
	 * This method deletes an user from the database by id. It return an boolean based of the row count of the affected
	 * rows.
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	public function deleteUserById( $id )
	{
		$sql               = "DELETE FROM {$this->tableName} WHERE id = :id ";
		$preparedStatement = $this->databaseConnection->prepare( $sql );

		$preparedStatement->execute( [ ":id" => $id ] );

		return ($preparedStatement->rowCount()) ? true : false;
	}

	protected function updateData( $sql, $params )
	{
		$sql = "UPDATE {$this->tableName} SET " . $sql . " WHERE id = ?";

		$preparedStatement = $this->databaseConnection->prepare( $sql );
		$counter           = 1;

		foreach( $params as $param => $paramType )
		{
			$preparedStatement->bindValue( $counter, $param, $paramType );
			$counter++;
		}

		return $preparedStatement->execute();
	}

	protected function getData( $sql, $params )
	{
		$sql = "SELECT `username`, `password`, `email` FROM {$this->tableName}" . $sql;

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

	protected function insertData( $sql, $params )
	{
		$sql = "INSERT INTO {$this->tableName} ( " . $sql . ") VALUES()";

		$sql = "INSERT INTO CampusWerk.users( `username`, `password`, `email` ) VALUES( ?,?,? ) ";

	}
}