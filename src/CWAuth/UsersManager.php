<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 3-10-15 - 2:29
 */

namespace CWAuth;

use CWAuth\Models\Authentication\Register;
use CWAuth\Models\Authentication\UserManager;


class UsersManager
{
	public $registerModel;
	public $userManagerModel;
	public $usersManagerModel;

	public function __construct()
	{
		$this->registerModel     = new Register();
		$this->userManagerModel  = new UserManager();
		$this->usersManagerModel = new UsersManager();
	}
}