<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleService {

	public function __construct(RoleRepository $repository) {
		$this->repository = $repository ;
	}

	public function index() {
		return $this->repository->all();
	}

	public function create($request) {
		if ($this->repository->checkRecord($request['name'])) {
            return response()->json([
                'success' => false,
                'message' => 'Record already exist'
            ])->setStatusCode(400);
        }
		return $this->repository->create($request);
	}

	public function update($request, $id) {
      return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($id) {
      return $this->repository->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->repository->search($queryFilter);
 	}
}