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

if (!function_exists('dateformat')) {
	/**
	 * [dateformat description]
	 * @param  [type] $date   [description]
	 * @param  string $style  [description]
	 * @param  string $format [description]
	 * @param  string $lang   [description]
	 * @return [type]         [description]
	 */
	function dateformat($date, $style = 'long', $format = '', $lang = 'id') {
		$arrMonth = [
			'1' => ($lang == 'id') ? (($style == 'long') ? 'Jan' : 'Jan') : (($style == 'long') ? 'January' : 'Jan'),
			'2' => ($lang == 'id') ? (($style == 'long') ? 'Feb' : 'Feb') : (($style == 'long') ? 'February' : 'Feb'),
			'3' => ($lang == 'id') ? (($style == 'long') ? 'Mar' : 'Mar') : (($style == 'long') ? 'March' : 'Mar'),
			'4' => ($lang == 'id') ? (($style == 'long') ? 'Apr' : 'Apr') : (($style == 'long') ? 'April' : 'Apr'),
			'5' => ($lang == 'id') ? (($style == 'long') ? 'Mei' : 'Mei') : (($style == 'long') ? 'May' : 'May'),
			'6' => ($lang == 'id') ? (($style == 'long') ? 'Jun' : 'Jun') : (($style == 'long') ? 'June' : 'Jun'),
			'7' => ($lang == 'id') ? (($style == 'long') ? 'Jul' : 'Jul') : (($style == 'long') ? 'July' : 'Jul'),
			'8' => ($lang == 'id') ? (($style == 'long') ? 'Ags' : 'Ags') : (($style == 'long') ? 'August' : 'Aug'),
			'9' => ($lang == 'id') ? (($style == 'long') ? 'Sep' : 'Sep') : (($style == 'long') ? 'September' : 'Sep'),
			'10' => ($lang == 'id') ? (($style == 'long') ? 'Okt' : 'Okt') : (($style == 'long') ? 'October' : 'Oct'),
			'11' => ($lang == 'id') ? (($style == 'long') ? 'Nov' : 'Nov') : (($style == 'long') ? 'November' : 'Nov'),
			'12' => ($lang == 'id') ? (($style == 'long') ? 'Des' : 'Des') : (($style == 'long') ? 'December' : 'Dec'),
		];

		if (empty($date)) {
			return 'N/A';
		}
		$time = strtotime($date);
		if ($lang == 'id') {
			if ($format == '') {
				return date('d', $time) . '-' . $arrMonth[date('n', $time)] . '-' . date('Y', $time);
			} elseif ($format == 'my') {
				return $arrMonth[date('n', $time)] . ' ' . date('Y', $time);
			}

		} else {
			if ($format == '') {
				return $arrMonth[date('n', $time)] . ' ' . date('d', $time) . ', ' . date('Y', $time);
			} else if ($format == 'my') {
				return $arrMonth[date('n', $time)] . ', ' . date('Y', $time);
			}

		}
	}
}

if (!function_exists('rupiah')) {
	function rupiah($data) {
		$result = number_format($data, 2);
		return $result;
	}
}
