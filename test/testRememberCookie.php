<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 27-10-15 - 14:45
 */

require( "header.php" );

try
{
	$rememberMe = new \CWAuth\Models\Authentication\RememberMeCookie();

	//$rememberMe->setAnRememberMeCookie( "1" );

	var_dump( $rememberMe->checkRememberMeCookie() );
}
catch( Exception $e )
{
	var_dump( $e );
}
