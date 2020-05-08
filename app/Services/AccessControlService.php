<?php

namespace App\Services;

use App\Person;
use App\Repositories\ShareRepository;
use App\Repositories\AccessControlRepository;
use App\Repositories\ParameterRepository;
use App\Repositories\RecordRepository;
use App\Services\SoapService;
use Illuminate\Http\Request;

class AccessControlService {

	public function __construct(
		AccessControlRepository $repository,
		Person $personModel,
		ShareRepository $shareRepository,
		ParameterRepository $parameterRepository,
		RecordRepository $recordRepository,
		SoapService $soapService
		) 
		{
		$this->repository = $repository;
		$this->personModel = $personModel;
		$this->shareRepository = $shareRepository;
		$this->parameterRepository = $parameterRepository;
		$this->recordRepository = $recordRepository;
		$this->soapService = $soapService;
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

	public function legacyAccesControlIngration($person, $type) {
		$person = $this->personModel->where('isPartner', $person)->first();
		if($person && $person->isPartner === $type) {
			return 1;
		}
		return 0;
	}

	public function checkPersonStatus($id) {
		$person = $this->personModel->where('id', $id)->with(['statusPerson'])->first();
		$status = $person->statusPerson()->first();
		return $person ? $status->description : '';
	}

	function validatePartner($request) {
		$status = 1;
		$message = '';
		$records = $this->recordRepository->getBlockedRecord($request['people_id']);
		if(count($records)) {
			foreach ($records as $key => $value) {
				$status = $status - 4;
				$message .= '* Presenta bloqueo activo por expediente :'.$value->id.',  hasta la fecha  '.$value->expiration_date.'<br>';
			}
		}



		$share = $this->shareRepository->find($request['share_id']);
		if($share->status === 0) {
			$message .= '* Accion Inactiva <br>';
			$status = $status -4;
		}

		$saldo = $this->soapService->getSaldo($share->share_number);
		if($saldo[0]->status < 1) {
			$message .= '* Accion no tiene saldo <br>';
			$status = $status -2;
		}

		$personStatus = $this->checkPersonStatus($request['people_id']);

		if($personStatus === "Inactivo"){
			$message .= '* Socio Inactivo <br>';
			$status = $status -4;
		}
		// if($request['selectedPartner'] === true) {
		// 	$data = $this->repository->create($request);
		// }
		return $message;
	}

	function validateMember($member, $shareId, $balance) {
		$status = 0;
		$message = '';

		if($balance < 0) {
			$status = $status -2;
		}

		$records = $this->recordRepository->getBlockedRecord($member);
		if(count($records)) {
			foreach ($records as $key => $value) {
				$status = $status - 4;
				$message .= 'Bloqueo activo por expediente :'.$value->id.',  hasta la fecha  '.$value->expiration_date.'<br>';
			}
		}

		$share = $this->shareRepository->find($shareId);
		if($share->status === 0) {
			$message .= '* Accion Inactiva <br>';
			$status = $status -4;
		}

		$personStatus = $this->checkPersonStatus($member);
		if($personStatus === "Inactivo"){
			$message .= '* Socio Inactivo <br>';
			$status = $status -4;
		}
		if($message !== '') {
			$currentPerson = $this->personModel->query(['name', 'last_name', 'rif_ci', 'card_number'])->where('id', $member)->first();
			$name = '<strong>'.$currentPerson->name.' '.$currentPerson->last_name.'</strong> Carnet: '.$currentPerson->card_number;
			$message = '<br><div><div>'.$name.'</div><div>'.$message.'</div></div>';
		}
		return (object)[ 'message' => $message, 'status' => $status ];
	}

	public function validateGuest($request, $balance) {
		if($request['guest_id'] !== "") {
			$request1 = $request;
			$status = 1;
			$message = '';
			
			if($balance < 0) {
				$status = $status -2;
			}

			$parameter = $this->parameterRepository->findByParameter('MAX_MONTH_VISITS_GUEST');
			$visits = $this->repository->getVisitsByMont($request1['guest_id']);
			$personStatus = $this->checkPersonStatus($request1['guest_id']);
			if($personStatus === "Inactivo"){
				$message .= '* Invitado Inactivo <br>';
				$status = $status -2;
			}
			if(count($visits) > $parameter->value) {
				$message .= '* Excede cantidad Maxima de visitas por Mes permitida : '.$parameter->value.'<br>';
				$status = $status - 8;
			}
			$request1['people_id'] = $request1['selectedPersonToAssignGuest'];
			$request1['isPartner'] = 3;
			$request1['status'] = $status;
			$this->repository->create($request1);
			return $message;
		}
	}

	public function create($request) {
		$share = $this->shareRepository->find($request['share_id']);
		$shareBalance = $this->soapService->getSaldo($share->share_number);
		$message = '';

		// $validatePartnerMessage = $this->validatePartner($request);
		// if($validatePartnerMessage !== '') {
		// 	$message.= '<strong>- Socio</strong>: <br>
		// 	'.$validatePartnerMessage.'
		// 	';
		// } else {
		// 	$this->legacyAccesControlIngration($request['people_id'], 1);
		// }

		if($request['guest_id'] !== null) {
			$validateGuestMessage = $this->validateGuest($request, $shareBalance[0]->status);
			$currentGuestPerson = $this->personModel->query(['name', 'last_name', 'rif_ci'])->where('id',$request['guest_id'])->first();
			$nameGuestPerson = $currentGuestPerson->name.' '.$currentGuestPerson->last_name.' CI: '.$currentGuestPerson->rif_ci;
			if($validateGuestMessage !== '') {
			$message.= '<br><strong>- Invitado</strong>: '.$nameGuestPerson.' <br>
			'.$validateGuestMessage.'
			';
		} else {
			$this->legacyAccesControlIngration($request['guest_id'], 3);
		}
		}

		if(count($request['family'])) {
			$status = 1;
			$familyMessage = '';
			foreach ($request['family'] as $element) {

				$validatePartnerMessage = $this->validateMember($element, $request['share_id'], $shareBalance[0]->status);
				$familyMessage .= $validatePartnerMessage->message;
				$request['people_id'] = $element;
				$request['status'] = $status + $validatePartnerMessage->status;
				$request['guest_id'] = NULL;
				$this->repository->create($request);
			}
			$message .= $familyMessage;
		}

		$balanceMessage = $shareBalance[0]->status < 0 ? '<div>* <strong>ATENCION:</strong> Accion N° '.$share->share_number.' presenta Saldo Deudor a la fecha</div><br>' : '';
		if($message !== '' || $balanceMessage !== "") {
			$generalMessage = $message !== '' ? '<div>Error de Ingreso para las siguientes personas:<div/> <div>'.$message.'</div>' : '';
			$body = '<div style="color: black">
			'.$balanceMessage.'
			'.$generalMessage.'
			</div>';
			return response()->json([
				'success' => false,
				'message' => $body,
			])->setStatusCode(400);
		}
		return response()->json([
			'success' => true,
			'message' => 'Access Created',
		])->setStatusCode(200);
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
	 
	 public function getPartnersFamilyStatistics() {
		return $this->repository->getPartnersFamilyStatistics();
	}

	public function getGuestStatistics() {
		return $this->repository->getGuestStatistics();
	}
}