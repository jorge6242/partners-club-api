<?php

namespace App\Services;

use App\Repositories\BankRepository;
use Illuminate\Http\Request;

class BankService {

	public function __construct(BankRepository $bank) {
		$this->bank = $bank ;
	}

	public function index($perPage) {
		return $this->bank->all($perPage);
	}

	public function create($request) {
		if ($this->bank->checkBank($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Bank already exist'
            ])->setStatusCode(400);
        }
		return $this->bank->create($request);
	}

	public function update($request, $id) {
      return $this->bank->update($id, $request);
	}

	public function read($id) {
     return $this->bank->find($id);
	}

	public function delete($id) {
      return $this->bank->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->bank->search($queryFilter);
 	}
}