<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
	/**
	 * [__construct description]
	 * @param UserRepositoryInterface $userRepository [description]
	 */
	public function __construct(UserRepositoryInterface $userRepository, Request $request) {
		$this->userRepository = $userRepository;
		$this->request = $request;
	}

	/**
	 * [getRegister description]
	 * @return [type] [description]
	 */
	public function getRegister() {
		if (checkLogin()) {
			return redirect('user/profile');
		}
		return view('auth.register');
	}

	/**
	 * [getLogin description]
	 * @return [type] [description]
	 */
	public function getLogin() {
		if (checkLogin()) {
			return redirect('/');
		}
		return view('auth.login');
	}

	/**
	 * [postLogin description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function postLogin() {

		$validator = Validator::make($this->request->all(), [
			'email' => 'required',
			'password' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		$username = $this->request->input('email');
		$password = $this->request->input('password');
		$login = $this->userRepository->login($username, $password);
		/*$validator->after(function ($validator) use ($login) {
			if (true !== $login->status) {
				$validator->errors()->add('email', trans('validation.custom.invalid_username_password'));
			}
		});*/
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		if (200 == $login->code) {
			return response()->json(['status' => 'OK', 'status_code' => $login->code]);
		} else {
			return response()->json(['status' => 'NOT_OK', 'message' => $login->message, 'status_code' => $login->code]);
		}

	}

	public function postRegistration() {
		$validator = Validator::make($this->request->all(), [
			'email' => 'required',
			'password' => 'required',
			'name' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		$data = [
			'email' => $this->request->email,
			'password' => $this->request->password,
			'name' => $this->request->name,
		];

		$register = $this->userRepository->registration($data);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		if (200 == $register->code) {
			return response()->json(['status' => 'OK', 'message' => $register->message, 'status_code' => $register->code]);
		} else {
			return response()->json(['status' => 'NOT_OK', 'message' => $register->message, 'status_code' => $register->code]);
		}
	}

	/**
	 * [logout description]
	 * @return [type] [description]
	 */
	public function logout() {
		$this->userRepository->logout();
		return redirect('/login');
	}

}
