<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserService {

		public function __construct(UserRepository $repository) {
			$this->repository = $repository ;
		}

		public function index() {
			return $this->repository->all();
		}
		
		public function create($request) {
			$request['password'] = bcrypt($request['password']);
			return $this->repository->create($request);
		}

		public function update($request, $id) {
			$user = $this->repository->find($id);
			$user->revokeAllRoles();
			$user = $this->repository->find($id);
			$roles = json_decode($request['roles']);
			
			if(count($roles)) {
				foreach ($roles as $role) {
					$user->assignRole($role);
				}
			}
			return $this->repository->update($id, $request);
		}

		public function read($id) {
						return $this->repository->find($id);
		}

		public function delete($id) {
							return $this->repository->delete($id);
		}

		public function checkUser($user) {
			return $this->repository->checkUser($user);
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