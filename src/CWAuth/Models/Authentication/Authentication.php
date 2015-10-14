<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-9-15 - 14:53
 * Licence: GPLv3
 */

namespace CWAuth\Models\Authentication;


trait AuthenticationDatabase
{
	protected $authenticationDatabase;

	public function __construct(  )
	{
		$this->authenticationDatabase = new \CWAuth\Models\Storage\AuthenticationDatabase();
	}
}