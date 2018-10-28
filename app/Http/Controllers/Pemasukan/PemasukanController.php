<?php

namespace App\Http\Controllers\Pemasukan;

use App\Http\Controllers\Controller;
use App\Repositories\Pemasukan\PemasukanRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PemasukanController extends Controller {

	/**
	 * [__construct description]
	 * @param PemasukanRepositoryInterface $pemasukanRepository [description]
	 * @param Request                      $request             [description]
	 */
	public function __construct(
		PemasukanRepositoryInterface $pemasukanRepository,
		UserRepositoryInterface $userRepository,
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

	public function listPemasukan(Request $request, $datatable = null) {
		if (checkLogin()) {
			$profile = $this->userRepository->getProfile();
			$pemasukan = $this->pemasukanRepository->getList();
			if (401 == $pemasukan->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}

		$data = new Collection($pemasukan->data);
		$datatables = Datatables::of($data)
			->editColumn('no', function ($data) {
				return $data['id'];
			})
			->editColumn('title', function ($data) {
				return $data['title'];
			})

			->editColumn('description', function ($data) {
				return $data['deskripsi'];
			})

			->editColumn('nominal', function ($data) {
				return 'IDR. ' . rupiah($data['jumlah']);
			})

			->editColumn('date', function ($data) {
				return dateformat($data['created_at']);
			})

			->editColumn('action', function ($data) {
				return '<a href="" class="btn btn-danger btn-xs"> <i class="fa fa-trash"></i></a>';
			})

			->filter(function ($instance) use ($request) {
				if ($request->has('date')) {
					$instance->collection = $instance->collection->filter(function ($row) use ($request) {
						return Str::contains($row['date'], $request->get('date')) ? true : false;
					});
				}

			});

		return $datatables->make(true);

	}

	public function input() {
		if (checkLogin()) {
			$profile = $this->userRepository->getProfile();
			if (401 == $profile->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}
		return view('pemasukan.input', compact('profile'));
	}

	public function store() {
		$validator = Validator::make($this->request->all(), [
			'title' => 'required',
			'nominal' => 'required',
			'deskripsi' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		$data = [
			'title' => $this->request->title,
			'jumlah' => $this->request->nominal,
			'deskripsi' => $this->request->deskripsi,
		];

		$input = $this->pemasukanRepository->inputPemasukan($data);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		if (200 == $input->code) {
			return response()->json(['status' => 'OK', 'message' => $input->message, 'status_code' => $input->code]);
		} else {
			return response()->json(['status' => 'NOT_OK', 'message' => $input->message, 'status_code' => $input->code]);
		}
	}

}
