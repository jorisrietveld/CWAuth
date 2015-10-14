<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 19:52
 * Licence: GPLv3
 */

namespace CWAuth\Models\Storage;

use \CWAuth\Helper\Arr;
use \CWDatabase\DatabaseConnection;


class AuthenticationDatabase
{
	protected $databaseConnection = null;
	protected $userDatabaseConfig;

	public function __construct()
	{
		$this->getDatabaseConfiguration();
	}

	private function getDatabaseConfiguration()
	{
		$path     = WEBSERVER_ROOT_PATH . "CWAuth" . DIRECTORY_SEPARATOR . "Config" . DIRECTORY_SEPARATOR;
		$fileName = "dbconfig.xml";

		$config = simplexml_load_file( $path . $fileName );

		if( $config )
		{
			$config = Arr::xml2array( $config );

			$this->userDatabaseConfig = $config[ "userDatabaseConnection" ];
		}
		else
		{
			// TODO  throw exception if the xml configured connection does not exist.
			$this->userDatabaseConfig = [
				"name"     => "userDatabaseConnection",
				"driver"   => "mysql",
				"host"     => "127.0.0.1",
				"database" => "CampusWerk",
				"username" => "root",
				"password" => "toor",
				"port"     => "3306",
				"charset"  => "utf8"
			];
		}
	}

	protected function openConnection()
	{
		if( !$this->databaseConnection )
		{
			$this->databaseConnection = new DatabaseConnection( $this->userDatabaseConfig );
		}
	}

	public function getConnection()
	{
		$this->openConnection();

		return $this->databaseConnection;
	}

}