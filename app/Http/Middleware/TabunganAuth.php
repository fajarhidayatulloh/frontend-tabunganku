<?php

namespace App\Http\Middleware;

use Closure;

class TabunganAuth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$credentials = $request->session()->get('credentials');
		if ($credentials === null) {
			return redirect('login');
		}
		return $next($request);
	}
}
