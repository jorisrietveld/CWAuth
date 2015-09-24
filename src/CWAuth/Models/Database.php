<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 11-9-15 - 13:44
 * Licence: GPLv3
 */

namespace CWAuth\Models;

use CWDatabase\DatabaseConnection;


class Database
{
	const CONFIG_USER_DB = "userDatabaseConnection";

	private $config;
	private $databaseConnection = null;

	public function __construct(  )
	{
	}

	public function parseDatabaseConfig( $file = "" )
	{
		$file = ( strlen( $file ) < 1 ) ? PROJECT_ROOT . "/Config/dbconfig.xml" : $file;

		$xmlConfigObject = simplexml_load_file( $file );

		if( $xmlConfigObject == false )
		{
			throw new \Exception( "Can't load the database coniguration file from {$file}." );
		}

		$this->config = (array)$xmlConfigObject->{self::CONFIG_USER_DB};
	}

	protected function connectToDatabase()
	{
		$this->parseDatabaseConfig();
		$cwDatabaseConnection = new DatabaseConnection( $this->config );
		$this->databaseConnection = $cwDatabaseConnection->getConnection();
	}

	/**
	 * @return mixed
	 */
	public function getDatabaseConnection()
	{
		if( $this->databaseConnection == null )
		{
			$this->connectToDatabase();
		}
		return $this->databaseConnection;
	}

	/**
	 * @param mixed $databaseConnection
	 */
	protected function setDatabaseConnection( $databaseConnection )
	{
		$this->databaseConnection = $databaseConnection;
	}

	/**
	 * @return mixed
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * @param mixed $config
	 */
	public function setConfig( $config )
	{
		$this->config = $config;
	}
}