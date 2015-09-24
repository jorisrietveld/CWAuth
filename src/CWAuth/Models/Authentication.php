<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-9-15 - 14:53
 * Licence: GPLv3
 */

namespace CWAuth\Models;

class Authentication
{
	const FEEDBACK_USER_NOT_FOUND =;
	const FEEDBACK_USER_PASSWORD_MIS = ;

	protected $user;
	private $feedback = [];

	public function __construct(  )
	{
		$this->user = new User();
	}


	public function login( $username, $password, $remember )
	{

	}

	public function getUser( $username )
	{
		$user = $this->user->getByUsername( $username );
		if( count(  $user ) )
		{
			return $user[ 0 ];
		}
	}

	protected function setFeedback( $message )
	{

	}

	public function getFeedback()
	{

	}
}