<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Repositories\Pengeluaran\PengeluaranRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class PengeluaranController extends Controller {

	/**
	 * [__construct description]
	 * @param PemasukanRepositoryInterface $pemasukanRepository [description]
	 * @param Request                      $request             [description]
	 */
	public function __construct(PengeluaranRepositoryInterface $pengeluaranRepository, UserRepositoryInterface $userRepository,
		Request $request) {
		$this->pengeluaranRepository = $pengeluaranRepository;
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
			$pengeluaran = $this->pengeluaranRepository->getPengeluaran();
			if (401 == $pengeluaran->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}
		return view('Pengeluaran.pengeluaran', compact('pengeluaran', 'profile'));
	}

}
