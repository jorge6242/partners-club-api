<?php

namespace App\Services;

use App\Repositories\ShareMovementRepository;
use Illuminate\Http\Request;

class ShareMovementService {

	public function __construct(ShareMovementRepository $model) {
		$this->model = $model ;
	}

	public function index($perPage) {
		return $this->model->all($perPage);
	}

	public function create($request) {
		if ($this->model->checkBank($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Record already exist'
            ])->setStatusCode(400);
        }
		return $this->model->create($request);
	}

	public function update($request, $id) {
      return $this->model->update($id, $request);
	}

	public function read($id) {
     return $this->model->find($id);
	}

	public function delete($id) {
      return $this->model->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->model->search($queryFilter);
 	}
}