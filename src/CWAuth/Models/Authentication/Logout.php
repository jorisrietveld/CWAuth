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
	protected $authenticationSession;
	protected $cookie;

	public function __construct( AuthenticationSession $authenticationSession = null, Cookie $cookie = null )
	{
		$this->authenticationSession = ( $authenticationSession ) ? $authenticationSession : new AuthenticationSession();
		$this->cookie                = ( $cookie ) ? $cookie : new Cookie();
	}

	public function deAuthenticateUser()
	{
		// Regenerate the session id and destroy the old session.
		session_regenerate_id( true );

		$this->authenticationSession->removeSessionData();

		$this->deleteCookie();
	}

	public function deleteCookie()
	{
		$this->cookie->deleteCookie( RememberMeCookie::REMEMBER_ME_COOKIE_NAME );
	}
}