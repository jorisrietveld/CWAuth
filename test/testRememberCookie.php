<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 27-10-15 - 14:45
 */

require( "header.php" );

try
{
	$rememberMe = new \CWAuth\Models\Authentication\RememberMeCookie();

	if( isset( $_GET[ "setCookie" ] ) )
	{
		switch( $_GET[ "setCookie" ] )
		{
			case "set cookie       ":
				$rememberMe->setAnRememberMeCookie( "1" );
			break;

			case "destroy cookie" :
				$rememberMe->deleteAnRememberMeCookie( "1" );
			break;
		}
	}

	//var_dump( $rememberMe->checkRememberMeCookie() );
	var_dump($_COOKIE);
}
catch( Exception $e )
{
	var_dump( $e );
}

echo <<<HTML

<form method="get" action="testRememberCookie.php">
<input name="setCookie" type="submit" value="set cookie       " />
</form>
<br>
<form method="get" action="testRememberCookie.php">
<input name="setCookie" type="submit" value="destroy cookie"/>
</form>
HTML;

