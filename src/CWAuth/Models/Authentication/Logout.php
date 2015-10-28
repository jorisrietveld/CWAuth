<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 15-10-15 - 11:05
 */

namespace CWAuth\Models\Authentication;

use CWAuth\Models\Storage\AuthenticationSession;
use CWAuth\Models\Storage\Cookie;


class Logout
{
	public function deAuthenticateUser(  )
	{
		session_regenerate_id(true);

		$authenticationSession = new AuthenticationSession();
		$authenticationSession->removeSessionData();

		$this->deleteCookie();
	}

	public function deleteCookie()
	{
		$cookie = new Cookie();
		$cookie->deleteCookie( RememberMeCookie::REMEMBER_ME_COOKIE_NAME );
	}
}