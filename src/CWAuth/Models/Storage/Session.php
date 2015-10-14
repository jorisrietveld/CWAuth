<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 19:51
 * Licence: GPLv3
 */

namespace CWAuth\Models\Storage;

class Session
{
	const SESSION_NAME = "";
	const SESSION_DOMAIN = "";

	public function __construct()
	{
		if( session_status() == PHP_SESSION_NONE )
		{
			session_start();
		}
	}

	public function getName()
	{

	}

	public function setName()
	{

	}
}