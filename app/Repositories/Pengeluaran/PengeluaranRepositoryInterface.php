<?php
namespace App\Repositories\Pengeluaran;

interface PengeluaranRepositoryInterface {

	/**
	 * [getList description]
	 * @return [type] [description]
	 */
	public function getList();

	/**
	 * [getPengeluaran description]
	 * @return [type] [description]
	 */
	public function getPengeluaran();

	/**
	 * [inputPengeluaran description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inputPengeluaran($data);

}
