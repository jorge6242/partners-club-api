<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserService {

		public function __construct(UserRepository $user) {
			$this->user = $user ;
		}

		public function index() {
			return $this->user->all();
		}
		
		public function create($request) {
			$request['password'] = bcrypt($request['password']);
			return $this->user->create($request);
		}

		public function update($request, $id) {
							return $this->user->update($id, $request);
		}

		public function read($id) {
						return $this->user->find($id);
		}

		public function delete($id) {
							return $this->user->delete($id);
		}

		public function checkUser($user) {
			return $this->user->checkUser($user);
		}

		public function checkLogin() {
			if (Auth::check()) {
				return response()->json([
					'success' => true,
					'data' => Auth::user()
				]);
			}
			return response()->json([
                'success' => false,
                'message' => 'You must login first'
            ])->setStatusCode(401);
		}
}