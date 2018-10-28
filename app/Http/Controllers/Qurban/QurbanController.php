<?php

namespace App\Http\Controllers\Qurban;

use App\Http\Controllers\Controller;
use App\Repositories\Qurban\QurbanRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

	public function listQurban(Request $request, $datatable = null) {
		if (checkLogin()) {
			$profile = $this->userRepository->getProfile();
			$qurban = $this->qurbanRepository->getList();
			if (401 == $profile->code) {
				$this->userRepository->logout();
				return redirect('login');
			}
		}

		$data = new Collection($qurban->data);
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
		return view('Qurban.input', compact('profile'));
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

		$input = $this->qurbanRepository->inputQurban($data);

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
