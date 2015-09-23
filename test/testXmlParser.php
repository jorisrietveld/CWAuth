<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 22-9-15 - 9:27
 * Licence: GPLv3
 */

require( "header.php" );

/*require( "../Config/dbconfig.xml" );*/

$config = simplexml_load_file("../Config/dbconfig.xml");

if( empty( $config ))
{
	throw new LogicException("no xml conf file found");
}
else
{
	var_dump($config );
}
echo '<strong>var_dump( $config->getName());</strong>';
var_dump( $config->getName());

echo '<strong>var_dump( $config->getNamespaces());</strong>';
var_dump( $config->getNamespaces());

echo '<strong>var_dump( $config->getDocNamespaces() );</strong>';
var_dump( $config->getDocNamespaces() );

echo '<strong>var_dump( $config->attributes() );</strong>';
var_dump( $config->attributes() );

echo 'var_dump( $config->count() );';
var_dump( $config->count() );

echo 'var_dump( $config->asXML() );';
var_dump( $config->asXML() );

