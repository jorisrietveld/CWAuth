<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 27-10-15 - 14:45
 */

require( "header.php" );

$rememberMe = new \CWAuth\Models\Authentication\RememberMeCookie();

$rememberMe->setAnRememberMeCookie( "1" );