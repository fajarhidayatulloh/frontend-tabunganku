<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\Tabungan\TabunganRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class HomeController extends Controller {
	/**
	 * [__construct description]
	 * @param ProductRepositoryInterface $productRepository [description]
	 */
	public function __construct(TabunganRepositoryInterface $tabunganRepository, UserRepositoryInterface $userRepository) {
		$this->tabunganRepository = $tabunganRepository;
		$this->userRepository = $userRepository;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index() {

		if (checkLogin()) {
			$profile = $this->userRepository->getProfile();
			$tabungan = $this->tabunganRepository->getTabungan();
			if (401 == $tabungan->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}
		return view('home', compact('profile', 'tabungan'));
	}
}
