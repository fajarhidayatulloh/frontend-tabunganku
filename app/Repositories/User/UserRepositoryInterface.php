<?php
namespace App\Repositories\User;

/*
ProductRepositoryInterface
 */
interface UserRepositoryInterface {

	/**
	 * [login description]
	 * @param  [type] $username [description]
	 * @param  [type] $password [description]
	 * @return [type]           [description]
	 */
	public function login($username, $password);

	/**
	 * [logout description]
	 * @return [type] [description]
	 */
	public function logout();

	/**
	 * [registration description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function registration($data);

	/**
	 * [updateProfile description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function updateProfile($data);

	/**
	 * [forgotPassword description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function forgotPassword($data);

	/**
	 * [checkForgotPassword description]
	 * @param  [type] $id   [description]
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	public function checkForgotPassword($id, $code);

	/**
	 * [resetPassword description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function resetPassword($data);
}
