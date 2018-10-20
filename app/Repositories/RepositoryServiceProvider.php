<?php
namespace App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

	public function register() {
		$this->app->bind('App\Repositories\Pemasukan\PemasukanRepositoryInterface', 'App\Repositories\Pemasukan\PemasukanRepository');
		$this->app->bind('App\Repositories\User\UserRepositoryInterface', 'App\Repositories\User\UserRepository');
		$this->app->bind('App\Repositories\Tabungan\TabunganRepositoryInterface', 'App\Repositories\Tabungan\TabunganRepository');
		$this->app->bind('App\Repositories\Pengeluaran\PengeluaranRepositoryInterface', 'App\Repositories\Pengeluaran\PengeluaranRepository');
		$this->app->bind('App\Repositories\Qurban\QurbanRepositoryInterface', 'App\Repositories\Qurban\QurbanRepository');

	}
}
