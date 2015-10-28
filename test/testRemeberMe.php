<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 29-10-15 - 0:18
 */

require( "header.php" );

$authentication = new \CWAuth\Authentication();

$_SESSION = null;

var_dump( $authentication->checkRememberMeCookie());