<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 16:04
 * Licence: GPLv3
 */

require( "header.php" );

use \CWAuth\Helper\Arr;


$array = [ "key1" => "val1", "key2" => "val2", "key3" => [ "innerKey1" => "innerVal1" ] ];

var_dump( Arr::get( $array, "key3.innerkey1" ) );