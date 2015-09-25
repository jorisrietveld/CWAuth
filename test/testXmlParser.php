<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 22-9-15 - 9:27
 * Licence: GPLv3
 */

require( "header.php" );

/*require( "../Config/dbconfig.xml" );*/

$config = simplexml_load_file( "../Config/dbconfig.xml" );

if( empty( $config ) )
{
	throw new LogicException( "no xml conf file found" );
}
else
{
	var_dump( $config );
}
echo '<strong>var_dump( $config->getName());</strong>';
var_dump( $config->getName() );

echo '<strong>var_dump( $config->getNamespaces());</strong>';
var_dump( $config->getNamespaces() );

echo '<strong>var_dump( $config->getDocNamespaces() );</strong>';
var_dump( $config->getDocNamespaces() );

echo '<strong>var_dump( $config->attributes() );</strong>';
var_dump( $config->attributes( "mysql-connection" ) );

echo '<strong>var_dump( $config->count() );</strong>';
var_dump( $config->count() );

echo '<strong>var_dump( $config->asXML() );</strong>';
var_dump( $config->asXML() );

$dbconfig = (array)$config->userDatabaseConnection;

var_dump( $dbconfig );

echo <<<HTML
	<hr><h1>Parse error messages</h1>
HTML;

$errorMessages = simplexml_load_file( "../Config/messages.xml" );

if( empty( $errorMessages ) )
{
	throw new LogicException( "no xml conf file found" );
}

var_dump( (array)$errorMessages );

$messagesArray = (array)$errorMessages;
var_dump( $messagesArray );
