<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 28-10-15 - 17:08
 */
function thisIsTheIndex()
{
};
try
{
	require( "header.php" );

	$session = new \CWAuth\Models\Storage\Session();
	$session->sessionStart();

	set_error_handler( function ( $errno, $errstr, $errfile, $errline, $errcontext )
	{
		throw new ErrorException( $errstr, 0, $errno, $errfile, $errline );
	} );

	if( !empty( $_POST[ "username" ] ) && !empty( $_POST[ "password" ] ) && !empty( $_POST[ "email" ] ) )
	{
		extract( $_POST );
		$userManager = new \CWAuth\UsersManager();
		if( $userManager->registerUser( $username, $password, $email ))
		{
			echo "<h3>The user is registered</h3>";
		}
		else
		{
			echo "<h3>The user is not registered</h3>";
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