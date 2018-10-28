<?php
namespace App\Repositories\Qurban;

interface QurbanRepositoryInterface {

	/**
	 * [getList description]
	 * @return [type] [description]
	 */
	public function getList();

	/**
	 * [getQurban description]
	 * @return [type] [description]
	 */
	public function getQurban();

	/**
	 * [inputQurban description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function inputQurban($data);

}
