<?php
namespace App\Repositories\Pengeluaran;

use App\Repositories\RestClient;

class PengeluaranRepository implements PengeluaranRepositoryInterface {
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
		$url = config('api.list_pengeluaran');
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
	 * [getPengeluaran description]
	 * @return [type] [description]
	 */
	public function getPengeluaran() {
		$url = config('api.get_pengeluaran');
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
	 * [inputPengeluaran description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inputPengeluaran($data) {
		$url = config('api.input_pengeluaran');
		$result = $this->api->post($url, $data);
		$return = new \stdClass();
		$return->code = $result->code;
		$return->message = isset($result->message->message) ? $result->message->message : $result->data['message'];

		return $return;
	}

}
