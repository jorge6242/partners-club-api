<?php

namespace App\Services;

use App\Repositories\BankRepository;
use Illuminate\Http\Request;

class BankService {

	public function __construct(BankRepository $bank) {
		$this->bank = $bank ;
	}

	public function index() {
		return $this->bank->all();
	}

	public function create($request) {
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
}