<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Repositories\Pengeluaran\PengeluaranRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

	/**
	 * [listPengeluaran description]
	 * @param  Request $request   [description]
	 * @param  [type]  $datatable [description]
	 * @return [type]             [description]
	 */
	public function listPengeluaran(Request $request, $datatable = null) {
		if (checkLogin()) {
			$profile = $this->userRepository->getProfile();
			$pengeluaran = $this->pengeluaranRepository->getList();
			if (401 == $profile->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}

		$data = new Collection($pengeluaran->data);
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

	/**
	 * [input description]
	 * @return [type] [description]
	 */
	public function input() {
		if (checkLogin()) {
			$profile = $this->userRepository->getProfile();
			if (401 == $profile->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}
		return view('Pengeluaran.input', compact('profile'));
	}

	/**
	 * [store description]
	 * @return [type] [description]
	 */
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

		$input = $this->pengeluaranRepository->inputPengeluaran($data);

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
