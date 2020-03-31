<?php

namespace App\Http\Controllers;

use SoapClient;
use Artisaninweb\SoapWrapper\SoapWrapper;
use App\Soap\Request\GetConversionAmount;
use App\Soap\Response\GetConversionAmountResponse;

class WebServiceController
{
  /**
   * @var SoapWrapper
   */
  protected $soapWrapper;

  /**
   * SoapController constructor.
   *
   * @param SoapWrapper $soapWrapper
   */
  public function __construct(SoapWrapper $soapWrapper)
  {
    $this->soapWrapper = $soapWrapper;
  }

  /**
   * Use the SoapWrapper
   */
  public function show() 
  {
    $domain_id = "CCC";
    $date = date('Ymd');
    $calculatedToken = base64_encode(strtoupper(md5($domain_id.$date)));

    $opts = array(
      'ssl' => array('ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
    );
    $params = array (
      'encoding' => 'UTF-8', 
      'verifypeer' => false, 
      'verifyhost' => false, 
      'soap_version' => SOAP_1_2, 
      'trace' => 1, 'exceptions' => 1, 
      "connection_timeout" => 180, 
      'stream_context' => stream_context_create($opts),
    );
    $url = "http://190.216.224.53:8080/wsServiciosSociosCCC2/wsSociosCCC.asmx?WSDL";

      try{
          $client = new SoapClient($url,$params);
          $response = $client->GetSaldoCSV([
            'group_id' => 'P-0004',
            'token' => $calculatedToken,
          ])->GetSaldoCSVResult;
          dd($response);
      }
      catch(SoapFault $fault) {
          echo '<br>'.$fault;
      }
}
}