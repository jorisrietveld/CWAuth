<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 11-9-15 - 14:11
 * Licence: GPLv3
 */

require( "header.php" );
require( ".." . DIRECTORY_SEPARATOR . "Config" . DIRECTORY_SEPARATOR . "databaseConfigExample.php" );

try
{
	$connectionParams = $connections[ "mysqlConnection" ];

	$dbModel = new \CWAuth\Models\Database();

	$dbting = $dbModel->getDatabaseConnection();


}
catch( \Exception $e )
{
	var_dump( $e );
}