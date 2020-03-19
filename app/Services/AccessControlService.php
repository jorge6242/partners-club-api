<?php

namespace App\Services;

use App\Repositories\AccessControlRepository;
use Illuminate\Http\Request;

class AccessControlService {

	public function __construct(AccessControlRepository $repository) {
		$this->repository = $repository ;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function filter($queryFilter, $isPDF = false) {
		return $this->repository->filter($queryFilter, $isPDF);
	}

	public function create($request) {
		$data = $this->repository->create($request);
		if($request['family']) {
			foreach ($request['family'] as $element) {
				$request['people_id'] = $element;
				$this->repository->create($request);
			}
		}
		if($request['guest_id'] !== "") {
			$request['guest_id'] = $request['guest_id'];
			$this->repository->create($request);
		}
		return $data;
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