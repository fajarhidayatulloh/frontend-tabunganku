<?php
namespace App\Repositories\Pemasukan;

interface PemasukanRepositoryInterface {

	/**
	 * [getList description]
	 * @return [type] [description]
	 */
	public function getList();

	/**
	 * [getPemasukan description]
	 * @return [type] [description]
	 */
	public function getPemasukan();

	/**
	 * [inputPemasukan description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inputPemasukan($data);

}
