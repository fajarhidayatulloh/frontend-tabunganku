<?php
namespace App\Repositories\User;

use App\Repositories\RestClient;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface {
	/**
	 * [__construct description]
	 */
	public function __construct() {
		$this->api = new RestClient();
	}

	/**
	 * [login description]
	 * @param  string $username [username]
	 * @param  string $password [password]
	 * @return object           [description]
	 */
	public function login($username, $password) {
		$url = config('api.user_login');
		$credentials = getCredentials();
		$credentials['username'] = $username;
		$credentials['password'] = $password;

		$result = $this->api->post($url, $credentials);
		$return = new \stdClass();
		$return->code = $result->code;
		$return->message = isset($result->message->message) ? $result->message->message : '';

		if (true === $result->status) {
			\Session::put('credentials', $result->data);
			$profile = $this->getProfile();
			if (401 == $profile->code) {
				\Session::flush();
				return $return;
			}

		}
		return $return;
	}

	/**
	 * [registration description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function registration($data) {
		$url = config('api.user_register');
		$result = $this->api->post($url, $data);
		$return = new \stdClass();
		$return->code = $result->code;
		$return->message = isset($result->message->message) ? $result->message->message : $result->data['message'];

		return $return;
	}

	/**
	 * [getProfile description]
	 * @return [type] [description]
	 */
	public function getProfile() {
		$url = config('api.user_profile');
		$result = $this->api->get($url);

		$profile = new \stdClass();
		$profile->status = false;
		$profile->code = $result->code;
		if ($result->status) {
			$profile->status = $result->status;
			$profile->data = $result->data['data'];
		}

		return $profile;
	}

	/**
	 * [logout revoke access token and delete token from my fund]
	 * @param  [type] $token [bareksa oauth access token]
	 * @return [type]        [description]
	 */
	public function logout() {
		$url = config('api.user_profile');
		$result = $this->api->get($url);

		if ($result->status !== false) {
			$this->api->get(config('api.user_logout'));
		}

		\Session::flush();
	}

	/**
	 * [updateProfile description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function updateProfile($data) {
		$url = config('api.update_profile');
		$result = $this->api->post($url, $data);
		$return = new \stdClass();
		$return->status = false;
		$return->code = $result->code;
		if ($result->status) {
			$return->status = $result->status;
		}

		return $return;
	}

	/**
	 * [forgotPassword description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function forgotPassword($data) {
		$url = config('api.forgot_password');
		$result = $this->api->post($url, $data);
		$return = new \stdClass();
		$return->status = false;
		$return->code = $result->code;
		if ($result->status) {
			$return->status = $result->status;
		}
		return $return;
	}

	/**
	 * [checkForgotPassword description]
	 * @param  [type] $id   [description]
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	public function checkForgotPassword($id, $code) {
		$url = config('api.check_fogot_password');
		$result = $this->api->get($url . '/' . $id . '/' . $code);
		$response = new \stdClass();
		$response->status = false;
		if ($result->status) {
			$response->status = $result->data['status'];
			$response->code = $result->code;
		}
		return $response;
	}

	/**
	 * [resetPassword description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function resetPassword($data) {
		$url = config('api.reset_fogot_password');
		$result = $this->api->post($url . '/' . $data['id'] . '/' . $data['token'], $data);
		$return = new \stdClass();
		$return->status = false;
		$return->code = $result->code;
		if ($result->status) {
			$return->status = $result->status;
			$return->code = $result->code;
		}
		return $return;
	}
}
