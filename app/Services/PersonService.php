<?php

namespace App\Services;

use App\Repositories\PersonRepository;
use App\Repositories\ProfessionRepository;
use App\Repositories\PersonProfessionRepository;
use Illuminate\Http\Request;

class PersonService {

	public function __construct(PersonRepository $person, PersonProfessionRepository $personProfessionRepository) {
		$this->person = $person;
		$this->personProfessionRepository = $personProfessionRepository;
	}

	public function index() {
		return $this->person->all();
	}

	public function reportAll() {
		return $this->person->reportAll();
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
			$professions = json_decode($request['profession_list']);
			return response()->json([
				'success' => true,
				'data' => $partner
			]);
		}

	}

	public function update($request, $id) {
	$image = $request['picture'];
	if (substr($image, 0, 4) === "http" ) {
		$request['picture'] = $request['rif_ci'].'.png';
	} else {
		if($image !== null) {
			\Image::make($request['picture'])->save(public_path('storage/partners/').$request['rif_ci'].'.png');
			$request['picture'] = $request['rif_ci'].'.png';
		} else {
			$request['picture'] = "partner-empty.png";
		}
	}
	if ($request['profession_list']) {
		$professions = json_decode($request['profession_list']);
		if(count($professions)) {
			if($this->personProfessionRepository->findPartner($id)){
				$this->personProfessionRepository->deleteRegistersbyPerson($id);
			}
			foreach ($professions as $profession) {
				$data = ['people_id' => $id, 'profession_id' => $profession];
				$this->personProfessionRepository->create($data);
			}
		}
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
	 
    /**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function searchByCompany($queryFilter) {
		return $this->person->searchByCompany($queryFilter);
 	}
}