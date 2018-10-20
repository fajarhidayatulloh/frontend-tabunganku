<?php

if (!function_exists('getCredentials')) {
	/**
	 * [getCredentials description]
	 * @return [type] [description]
	 */
	function getCredentials() {
		return [
			'grant_type' => config('api.oauth_grant_type'),
			'client_id' => config('api.oauth_client_id'),
			'client_secret' => config('api.oauth_client_secret'),
			'scope' => config('api.oauth_scope'),
		];
	}
}

if (!function_exists('initHeader')) {
	/**
	 * initHeader.
	 *
	 * @param  string  $text
	 * @return string
	 */
	function initHeader() {
		$header = [
			'Content-Type' => 'application/json',
			'Accept' => 'application/json',
			'Authorization' => '',
			'Client-Id' => config('api.oauth_client_id'),
			'Client-Secret' => config('api.oauth_client_secret'),
		];

		if (Session::has('credentials')) {
			$credentials = Session::get('credentials');
			$header['Authorization'] = $credentials['token_type'] . ' ' . $credentials['access_token'];
		}

		return $header;
	}
}

if (!function_exists('checkLogin')) {
	/**
	 * getAuthorization.
	 *
	 * @param  string  $text
	 * @return string
	 */
	function checkLogin() {
		if (Session::has('credentials')) {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('getProfile')) {
	/**
	 * getAuthorization.
	 *
	 * @param  string  $text
	 * @return string
	 */
	function getProfile() {
		return (object) Session::get('profile');
	}
}
