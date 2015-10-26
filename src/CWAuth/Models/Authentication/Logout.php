<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 15-10-15 - 11:05
 */

namespace CWAuth\Models\Authentication;

use CWAuth\Models\Storage\Cookie;
use CWAuth\Models\Storage\Session;


class Logout
{
	public function deAuthenticateUser(  )
	{
		Session::regenerateId( true );
		$this->deleteCookie();
	}

	public function deleteCookie()
	{
		$cookie = new Cookie();
		$cookie->deleteCookie( Login::REMEMBER_ME_COOKIE_NAME );
	}
}