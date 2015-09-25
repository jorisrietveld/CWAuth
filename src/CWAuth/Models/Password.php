<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 11:43
 * Licence: GPLv3
 */

namespace CWAuth\Models;

use CWAuth\Helper\Message;

class Password
{
	private $passwordOptions = [
		'cost' => 11,
		"algo" => PASSWORD_DEFAULT
	];

	public $passwordAutoGenerateSalt = false;
	public $saveMode                 = true;

	public function __construct( $options = [ ] )
	{
		foreach( $options as $option => $value )
		{
			if( $option == "saveMode" || $option == "passwordAutoGenerateSalt" )
			{
				$this->{$option} = $value;
			}
		}
	}

	public function passwordCheck( $password, $hash )
	{
		return password_verify( $password, $hash );
	}

	public function passwordHash( $password, $options = [ ] )
	{
		$this->passwordOptions = array_merge( $this->passwordOptions, $options );

		// if the password_hash auto generate salt is turned off.
		if( $this->passwordAutoGenerateSalt == false )
		{
			if( !empty( $this->passwordOptions[ "salt" ] ) )
			{
				$this->checkUserProvidedSalt();
			}
			else
			{
				$this->passwordOptions[ "salt" ] = $this->getSalt();
			}
		}
		elseif( isset( $this->passwordOptions[ "salt" ] ) )
		{
			unset( $this->passwordOptions[ "salt" ] );
		}

		$hashingAlgorithm = $this->passwordOptions[ "algo" ];

		return password_hash( $password, $hashingAlgorithm, $this->passwordOptions );
	}

	public function checkUserProvidedSalt()
	{
		if( $this->saveMode )
		{
			throw new \LogicException( Message::getMessage( "password.exceptions.saveModeOn" ) );
		}
		elseif( strlen( $this->passwordOptions[ "salt" ] ) < 22 )
		{
			throw new \LogicException( Message::getMessage( "password.exceptions.saltToShort" ) );
		}
	}

	public function getSalt( $saltLength = 40 )
	{
		$randomGenerator = new RandomGenerator();

		return $randomGenerator->getPseudoRandomBytes( $saltLength );
	}

	public function getPasswordInformation( $hash )
	{
		return password_get_info( $hash );
	}

	public function passwordNeedsRehash( $hash, $password )
	{
		$hashingAlgorithm = $this->passwordOptions[ "algo" ];

		if( password_needs_rehash( $hash, $hashingAlgorithm, $this->passwordOptions ) )
		{
			return true;
		}

		return false;
	}

	public function getHashingOptions()
	{
		return $this->passwordOptions;
	}
}