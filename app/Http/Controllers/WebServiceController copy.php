<?php

namespace App\Http\Controllers;

use SoapClient;
use App\Services\SoapService;

class WebServiceController extends Controller
{

  public function __construct(SoapService $soapService)
	{
		$this->soapService = $soapService;
    }

  public function getBalance()  { 
    $data = $this->soapService->getSaldo();
    return response()->json([
      'success' => true,
      'data' => $data,
    ]);;
  }

  public function getUnpaidInvoices()  { 
    return $this->soapService->getUnpaidInvoices();
  }

  public function getReportedPayments()  { 
    $data = $this->soapService->getReportedPayments();
    return response()->json([
      'success' => true,
      'data' => $data,
    ]);;
  }
   
}