<?php

namespace App\Http\Controllers\Qurban;

use App\Http\Controllers\Controller;
use App\Repositories\Qurban\QurbanRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class QurbanController extends Controller {

	/**
	 * [__construct description]
	 * @param PemasukanRepositoryInterface $pemasukanRepository [description]
	 * @param Request                      $request             [description]
	 */
	public function __construct(QurbanRepositoryInterface $qurbanRepository, UserRepositoryInterface $userRepository,
		Request $request) {
		$this->qurbanRepository = $qurbanRepository;
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
			$qurban = $this->qurbanRepository->getQurban();
			if (401 == $profile->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}
		return view('Qurban.qurban', compact('qurban', 'profile'));
	}

}
