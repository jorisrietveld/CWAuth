<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 28-10-15 - 15:29
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

	if( !empty( $_POST[ "username" ] ) && !empty( $_POST[ "password" ] ) && !empty( $_POST[ "remember" ] ) )
	{

		$authentication = new \CWAuth\Authentication();

		extract( $_POST );

		if( $authentication->login( $username, $password, $remember ) )
		{
			echo "<h3>The user is authenticated</h3>";
			echo "<h3>Debug: session data</h3>";
			var_dump( $_SESSION );
			echo "<h3>Debug: cookie data</h3>";
			var_dump( $_COOKIE );
		}
		else
		{
			echo "<h3 style='text-align: center'>The user is not authenticated</h3>";
			echo "<h4>Debug: feedback</h4>";
			var_dump( trim( $authentication->getFeedback() ) );
			echo "<h4>Debug: session data</h4>";
			var_dump( $_SESSION );
			echo "<h4>Debug: cookie data</h4>";
			var_dump( $_COOKIE );
		}
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