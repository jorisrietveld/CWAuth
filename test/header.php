<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 2-9-15 - 15:40
 * Licence: GPLv3
 */

/**
 * Used Constants.
 */
define( "WEBSERVER_ROOT_PATH", "/var/www/" );

include "../vendor/autoload.php";

function dump( $item, $showVarTypes = false )
{
	echo "<pre>";
	( $showVarTypes ) ? var_dump( $item ) : print_r( $item );
	echo "</pre>";
}

if( !function_exists( "thisIsTheIndex" ) )
{
	echo <<<HTML
	<!DOCTYPE html>
	<style>
	.illuminatiIsEveryWhere{
		background-color:dodgerblue;
		color:white;font-weight:bold;
		font-family: ubuntu;
		border-radius:10px;
		height:30px;
		width:200px;
		border:groove blue;
		text-align: center;
		vertical-align: middle;
	};
	</style>
	<script>
	function historyMinusOne()
	{
        window.location = "index.php";
	}
	</script>
HTML;
	echo "<button class='illuminatiIsEveryWhere' onclick='historyMinusOne()'><- Go back</button>";
}