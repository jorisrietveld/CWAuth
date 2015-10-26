<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-10-15 - 19:26
 */

require( "header.php" );

///////////////////////////////////////////////////////////////////////////////////////////////
echo "<hr><h3>Instantiate the DateTime class </h3>";

//$val1 = "2015-10-24 19:45:21";
//$val1 = time();
//$val1 = "19:45:21";
//$val1 = "2015-10-24";
//$val1 = "-1 day";
//$val1 = "+1 day";
//$val1 = "+1 month";
//$val1 = "-1 month";
//$val1 = "+1 year";
//$val1 = "-1 year";
//$val1 = "12";
//$val1 = "yesterday noon";
//$val1 = "first day of January 2008";
//$val1 = "last sat of July 2008";
//$val1 = null;
//$val1 = "";
//$val1 = 0;

$cdt = new \CWAuth\Helper\DateAndTime();

echo "<hr><h3>base value:{$val1}</h3>";

try
{
	echo "<hr><h3>To epoch</h3>";
	echo $cdt->ConvertToEpoch( $val1 );
}
catch( Exception $e )
{
	echo $e->getMessage();
}
try
{
	echo "<hr><h3>To mysqlTime</h3>";
	echo $cdt->ConvertToMysqlTime( $val1 );
}
catch( Exception $e )
{
	echo $e->getMessage();
}
try
{
	echo "<hr><h3>To mysqlDate</h3>";
	echo $cdt->ConvertToMysqlDate( $val1 );
}
catch( Exception $e )
{
	echo $e->getMessage();
}
try
{
	echo "<hr><h3>To mysqlDateTime</h3>";
	echo $cdt->ConvertToMysqlDateTime( $val1 );
}
catch( Exception $e )
{
	echo $e->getMessage();
}