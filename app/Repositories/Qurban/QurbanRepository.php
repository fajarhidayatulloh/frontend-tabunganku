<?php
namespace App\Repositories\Qurban;

use App\Repositories\RestClient;

class QurbanRepository implements QurbanRepositoryInterface {
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
		$url = config('api.list_qurban');
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
	 * [getQurban description]
	 * @return [type] [description]
	 */
	public function getQurban() {
		$url = config('api.get_qurban');
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
	 * [inputQurban description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inputQurban($data) {
		$url = config('api.input_qurban');
		$result = $this->api->post($url, $data);
		$return = new \stdClass();
		$return->code = $result->code;
		$return->message = isset($result->message->message) ? $result->message->message : $result->data['message'];

		return $return;
	}

}
