<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 2-10-15 - 21:37
 */

namespace CWAuth\contracts;

interface Authentication
{
	public function login( $username, $password, $remember = false );

	public function logout();

	public function isAuthenticated();

	public function getUserData();
}