<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-10-15 - 19:12
 */

namespace CWAuth\Helper;



class DateAndTime
{
	/**
	 * Converts an epoch, date or time string to the mysql date format.
	 *
	 * @param string $inputDateTime
	 * @return string
	 */
	public static function ConvertToMysqlDate( $inputDateTime = "now" )
	{
		$inputDateTime = is_numeric( $inputDateTime ) ? "@" . $inputDateTime : $inputDateTime;

		$date          = new \DateTime( $inputDateTime );

		return $date->format( "Y-m-d" );
	}

	/**
	 * Converts an epoch, date or time string to the mysql time format.
	 *
	 * @param string $inputDateTime
	 * @return string
	 */
	public static function ConvertToMysqlTime( $inputDateTime = "now" )
	{
		$inputDateTime = is_numeric( $inputDateTime ) ? "@" . $inputDateTime : $inputDateTime;

		$date = new \DateTime( $inputDateTime );

		return $date->format( "H:i:s" );
	}

	/**
	 * Converts an epoch, date or time string to the mysql datetime format.
	 *
	 * @param string $inputDateTime
	 * @return string
	 */
	public static function ConvertToMysqlDateTime( $inputDateTime = "now" )
	{
		$inputDateTime = is_numeric( $inputDateTime ) ? "@" . $inputDateTime : $inputDateTime;
		$date = new \DateTime( $inputDateTime );

		return $date->format( "Y-m-d H:i:s" );
	}

	/**
	 * Converts an epoch, date or time string to an epoch value.
	 *
	 * @param string $inputDateTime
	 * @return string
	 */
	public static function ConvertToEpoch( $inputDateTime = "now" )
	{
		$inputDateTime = is_numeric( $inputDateTime ) ? "@" . $inputDateTime : $inputDateTime;
		$date = new \DateTime( $inputDateTime );

		return $date->format( "U" );
	}
}
