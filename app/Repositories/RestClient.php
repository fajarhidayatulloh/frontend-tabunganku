<?php
namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class RestClient {

	/**
	 * [__construct description]
	 */
	public function __construct() {
		$this->api = new Client();
	}

	/**
	 * [post description]
	 * @param  string $url  [description]
	 * @param  array $data [description]
	 * @return object       [description]
	 */
	public function post($url, $data) {
		$return = new \stdClass();
		$return->code = 200;
		$return->status = false;
		$header = initHeader();
		try {
			$res = $this->api->post($url, ['headers' => $header, 'json' => $data]);

			if ($res->getStatusCode() == "200") {
				$return->status = true;
				$return->data = json_decode($res->getBody(), true);
			} else {
				$return->message = json_decode($res->getBody(), true);
			}
		} catch (RequestException $e) {
			if ($e->hasResponse()) {
				$errors = json_decode($e->getResponse()->getBody()->getContents());
				$return->message = $errors;
				$return->code = $e->getCode();
				if ($return->code != 401 && $return->code != 403) {
					Log::error($e);
				}
			} else {
				Log::error($e);
			}
		}
		return $return;
	}

	/**
	 * [get description]
	 * @param  string $url [description]
	 * @return object      [description]
	 */
	public function get($url) {
		$return = new \stdClass();
		$header = initHeader();
		try {
			$res = $this->api->get($url, ['headers' => $header]);
			$return = new \stdClass();
			$return->code = 200;
			if ($res->getStatusCode() == '200') {
				$return->status = true;
				$return->data = json_decode($res->getBody(), true);
			} else {
				$return->status = false;
			}
		} catch (RequestException $e) {
			if ($e->hasResponse()) {
				$errors = json_decode($e->getResponse()->getBody()->getContents());
				$return->message = $errors;
				$return->code = $e->getCode();
				if ($return->code != 401 && $return->code != 403) {
					Log::error($e);
				}
			} else {
				Log::error($e);
				$return->code = 0;
			}
			$return->status = false;
		}
		return $return;
	}
}
