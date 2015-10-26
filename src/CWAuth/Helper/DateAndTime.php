<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-10-15 - 19:12
 */

namespace CWAuth\Helper;

use CWDatabase\Helper\DatabaseLiteral;


class DateAndTime
{
	public static function ConvertToMysqlDate( $inputDateTime = "now" )
	{
		$date = new \DateTime( $inputDateTime );
		return $date->format( "Y-m-d" );
	}

	public static function ConvertToMysqlTime( $inputDateTime = "now")
	{
		$date = new \DateTime( $inputDateTime );
		return $date->format( "H:i:s" );
	}

	public static function ConvertToMysqlDateTime( $inputDateTime = "now" )
	{
		$date = new \DateTime( $inputDateTime );
		return $date->format( "Y-m-d H:i:s" );
	}

	public static function ConvertToEpoch( $inputDateTime = "now" )
	{
		$date = new \DateTime( $inputDateTime );
		return $date->format( "U" );
	}
}
