<?php

namespace App\Services;

use App\Repositories\CardPersonRepository;
use Illuminate\Http\Request;

class CardPersonService {

	public function __construct(CardPersonRepository $repository) {
		$this->repository = $repository ;
	}

	public function index($id) {
		return $this->repository->all($id);
	}

	public function create($request) {
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