<?php
namespace App\Repositories\Tabungan;

use App\Repositories\RestClient;

class TabunganRepository implements TabunganRepositoryInterface {
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
	public function getTabungan() {
		$url = config('api.get_tabungan');
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

}
