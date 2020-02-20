<?php

namespace App\Services;

use App\Repositories\PersonRepository;
use Illuminate\Http\Request;

class PersonService {

	public function __construct(PersonRepository $person) {
		$this->person = $person ;
	}

	public function index() {
		return $this->person->all();
	}

	public function create($request) {
		if ($this->person->checkPerson($request['rif_ci'])) {
            return response()->json([
                'success' => false,
                'message' => 'Person already exist'
            ])->setStatusCode(400);
		}
		$image = $request['picture'];
		if($image !== null) {
			\Image::make($request['picture'])->save(public_path('storage/partners/').$request['rif_ci'].'.png');
			$request['picture'] = $request['rif_ci'].'.png';
		} else {
			$request['picture'] = "partner-empty.png";
		}
		$response = $this->person->create($request);
		if ($response) {
			$partner = $this->person->checkPerson($request['rif_ci']);
			return response()->json([
				'success' => true,
				'data' => $partner
			]);
		}

	}

	public function update($request, $id) {
	$image = $request['picture'];
	if($image !== null) {
		\Image::make($request['picture'])->save(public_path('storage/partners/').$request['rif_ci'].'.png');
		$request['picture'] = $request['rif_ci'].'.png';
	} else {
		$request['picture'] = "partner-empty.png";
	}
      return $this->person->update($id, $request);
	}

	public function read($id) {
     return $this->person->find($id);
	}

	public function delete($id) {
      return $this->person->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->person->search($queryFilter);
 	}
}