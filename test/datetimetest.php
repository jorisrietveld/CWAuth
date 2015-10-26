<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-10-15 - 19:26
 */

require( "header.php" );

///////////////////////////////////////////////////////////////////////////////////////////////
echo "<hr><h3>Instantiate the DateTime class </h3>";

$val1 = "2015-10-24 19:45:21";

$cdt = new \CWAuth\Helper\DateAndTime();

echo "<hr><h3>To epoch</h3>";
echo $cdt->ConvertToEpoch( $val1 );

echo "<hr><h3>To mysqlTime</h3>";
echo $cdt->ConvertToMysqlTime( $val1 );

echo "<hr><h3>To mysqlDate</h3>";
echo $cdt->ConvertToMysqlDate( $val1 );

echo "<hr><h3>To mysqlDateTime</h3>";
echo $cdt->ConvertToMysqlDateTime( $val1 );