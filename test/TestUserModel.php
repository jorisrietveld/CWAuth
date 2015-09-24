<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-9-15 - 12:02
 * Licence: GPLv3
 */

require( "header.php" );

$userModel = new \CWAuth\Models\User();

var_dump( $userModel->getByUsername("jorisrietveld"));