<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 28-10-15 - 19:06
 */

function thisIsTheIndex()
{
}

;
try
{
	require( "header.php" );

	$session = new \CWAuth\Models\Storage\Session();
	$session->sessionStart();

	set_error_handler( function ( $errno, $errstr, $errfile, $errline, $errcontext )
	{
		throw new ErrorException( $errstr, 0, $errno, $errfile, $errline );
	} );

	if( !empty( $_POST[ "logout" ] ) )
	{
		$authentication = new \CWAuth\Authentication();
		$authentication->logout();

		echo "<h3>The user is signed out</h3>.";
		echo "<h3>Debug: session data</h3>";
		var_dump( $_SESSION );
		echo "<h3>Debug: cookie data</h3>";
		var_dump( $_COOKIE );
	}
	else
	{
		echo "<h3>not all required fields where send.";
	}
}
catch( Exception $e )
{
	echo "<div id='exception-show'>";
	echo "<h3>An exception was thrown</h3>";
	var_dump( $e );
	echo "</div>";
}