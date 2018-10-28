<?php
namespace App\Repositories\Pemasukan;

use App\Repositories\RestClient;

class PemasukanRepository implements PemasukanRepositoryInterface {
	/**
	 * [__construct description]
	 */
	public function __construct() {
		$this->api = new RestClient();
	}

	/**
	 * [getList description]
	 * @return [type] [description]
	 */
	public function getList() {
		$url = config('api.list_pemasukan');
		$result = $this->api->get($url);

		$return = new \stdClass();
		$return->status = false;
		$return->code = $result->code;
		if ($result->status) {
			$return->status = $result->status;
			$return->data = $result->data['data'];
		}

		return $return;
	}

	/**
	 * [getPemasukan description]
	 * @return [type] [description]
	 */
	public function getPemasukan() {
		$url = config('api.get_pemasukan');
		$result = $this->api->get($url);

		$return = new \stdClass();
		$return->status = false;
		$return->code = $result->code;

		if ($result->status) {
			$return->status = $result->status;
			$return->data = $result->data['data'];
		}

		return $return;
	}

	/**
	 * [inputPemasukan description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inputPemasukan($data) {
		$url = config('api.input_pemasukan');
		$result = $this->api->post($url, $data);
		$return = new \stdClass();
		$return->code = $result->code;
		$return->message = isset($result->message->message) ? $result->message->message : $result->data['message'];

		return $return;
	}

}
