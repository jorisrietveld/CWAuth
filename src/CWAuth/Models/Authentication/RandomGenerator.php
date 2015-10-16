<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 11:45
 * Licence: GPLv3
 */

namespace CWAuth\Models\Authentication;

use \CWAuth\Helper\Message;

class RandomGenerator
{
	// Supported sources to get pseudo random bytes.
	private $allowedSources = [ "urandom", "mcrypt", "openssl" ];
	// (Unix only) define the path to the urandom or random file (pseudo random number generator)
	private $uRandomPath    = "/dev/urandom";

	// The default amount of bytes to get.
	private $amountOfBytes = 10;

	// The preferred sources to get pseudo random bytes.
	private $preferredSources = [ ];
	// After getting bytes this will hold the source used.
	private $usedSource;
	// This will hold the bytes collected after calling getPseudoRandomBytes()
	private $bytes            = "";

	/**
	 * The first argument wil initialize the preferred sources for getting pseudo random bytes.
	 *
	 * @param array $preferredSources
	 */
	public function __construct( $preferredSources = [ "urandom", "mcrypt", "openssl" ] )
	{
		$this->preferredSources = $preferredSources;
	}

	/**
	 * This method returns pseudo random bytes from the preferred sources if available. if not it will throw an
	 * exception.
	 *
	 * @param int $amount
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getPseudoRandomBytes( $amount = 10 )
	{
		$this->amountOfBytes = $amount;

		foreach( $this->preferredSources as $source )
		{
			$methodName = "getBytesFrom" . ucfirst( $source );

			if( $bytes = $this->{$methodName}() )
			{
				$this->usedSource = $source;
				$this->bytes      = $bytes;

				return $this->bytes;
			}
		}

		if( !$this->bytes )
		{
			throw new \Exception( "randomGenerator.exceptions.noRandomSource", 1 );
		}
	}

	/**
	 * This method will attemt to open the urandom file and returens the amount of bytes set in the amount property.
	 *
	 * @return bool|string
	 */
	protected function getBytesFromUrandom()
	{
		if( in_array( "urandom", $this->getAvailableSources() ) )
		{
			// Open the urandom file and get the needed bytes from it.
			$uRandom = fopen( $this->uRandomPath, 'rb' );

			$bytes = fread( $uRandom, $this->amountOfBytes );
			fclose( $uRandom );

			return $bytes;
		}

		return false;
	}

	/**
	 * This method will try to use the mCrypt extension to get random bytes.
	 *
	 * @return bool|string
	 */
	protected function getBytesFromMcrypt()
	{
		if( in_array( "mcrypt", $this->getAvailableSources() ) )
		{
			// Check if the current os is windows, if so seed the random number generator. And set the proper iv flags.
			if( version_compare( PHP_VERSION, '5.3.7', '<' ) && strncasecmp( PHP_OS, 'WIN', 3 ) == 0 )
			{
				srand();
				$flag = MCRYPT_RAND;
			}
			else
			{
				$flag = MCRYPT_DEV_URANDOM;
			}

			$bytes = mcrypt_create_iv( $this->amountOfBytes, $flag );

			return $bytes;
		}

		return false;
	}

	/**
	 * This method will try get random bytes from the OpenSSL extension.
	 * @return bool|string
	 */
	protected function getBytesFromOpenSSL()
	{
		if( in_array( "openssl", $this->getAvailableSources() ) )
		{
			$bytes = openssl_random_pseudo_bytes( $this->amountOfBytes );

			return $bytes;
		}

		return false;
	}

	/**
	 * This method sets the path to where urandom or an similar pseudo random source file.
	 *
	 * @param $path
	 */
	public function setPathToURandom( $path )
	{
		$this->uRandomPath = $path;
	}

	/**
	 * This method will return an array with the preferred sources.
	 * @return mixed
	 */
	public function getPreferredSources()
	{
		return $this->preferredSources;
	}

	/**
	 * This method will test if pseudo random byte sources are available and returns an array with the available
	 * sources.
	 * @return array
	 */
	public function getAvailableSources()
	{
		$availableSources = [ ];

		if( is_readable( "/dev/urandom" ) && fopen( "/dev/urandom", "rb" ) !== false )
		{
			$availableSources[] = "urandom";
		}

		if( function_exists( "mcrypt_create_iv" ) )
		{
			$availableSources[] = "mcrypt";
		}

		if( function_exists( "openssl_random_pseudo_bytes" ) )
		{
			$availableSources[] = "openssl";
		}

		return $availableSources;
	}

	public static function getRandomBytes( $count )
	{
		$obj = self::__construct();
		return $obj->getPseudoRandomBytes( $count );
	}
}