<?php

$root_url = env('REST_API_HOST', 'http://127.0.0.1');
$version = env('REST_API_VERSION', 'v1');
return [
	'oauth_grant_type' => env('OAUTH_GRANT_TYPE', 'tabunganku_password'),
	'oauth_client_id' => env('OAUTH_CLIENT_ID', '7'),
	'oauth_client_secret' => env('OAUTH_CLIENT_SECRET', 'aqk6gSivAJV6hlJKeNrNTtQ7v6i3JWuNMD9JhFZa'),
	'oauth_scope' => env('OAUTH_SCOPE', '*'),

	//login
	'user_login' => $root_url . '/' . $version . '/oauth/token',
	//logout
	'user_logout' => $root_url . '/' . '/client/logout',
	//registration
	'user_register' => $root_url . '/' . 'client/registration',
	//profile user
	'user_profile' => $root_url . '/' . 'client/getProfile',

	//tabungan
	'get_tabungan' => $root_url . '/' . 'tabungan',

	//pemasukan
	'get_pemasukan' => $root_url . '/' . 'pemasukan',
	'list_pemasukan' => $root_url . '/' . 'pemasukan/data',
	'input_pemasukan' => $root_url . '/' . 'pemasukan/create',

	//pengeluaran
	'get_pengeluaran' => $root_url . '/' . 'pengeluaran',
	'list_pengeluaran' => $root_url . '/' . 'pengeluaran/data',
	'input_pengeluaran' => $root_url . '/' . 'pengeluaran/create',

	//tabungan qurban
	'get_qurban' => $root_url . '/' . 'qurban',
	'list_qurban' => $root_url . '/' . 'qurban/data',
	'input_qurban' => $root_url . '/' . 'qurban/create',
];
