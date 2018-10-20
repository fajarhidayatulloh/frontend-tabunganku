<?php

namespace App\Http\Controllers\Pemasukan;

use App\Http\Controllers\Controller;
use App\Repositories\Pemasukan\PemasukanRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class PemasukanController extends Controller {

	/**
	 * [__construct description]
	 * @param PemasukanRepositoryInterface $pemasukanRepository [description]
	 * @param Request                      $request             [description]
	 */
	public function __construct(PemasukanRepositoryInterface $pemasukanRepository, UserRepositoryInterface $userRepository,
		Request $request) {
		$this->pemasukanRepository = $pemasukanRepository;
		$this->userRepository = $userRepository;
		$this->request = $request;
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index() {
		if (checkLogin()) {
			$profile = $this->userRepository->getProfile();
			$pemasukan = $this->pemasukanRepository->getPemasukan();
			if (401 == $pemasukan->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}
		return view('Pemasukan.pemasukan', compact('pemasukan', 'profile'));
	}

}
