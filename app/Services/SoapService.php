<?php

namespace App\Services; 

use SoapClient;

class SoapService
{

  public function getToken() {
    date_default_timezone_set('America/Caracas');
    $domain_id = "CCC";
    $date = date('Ymd');
    $calculated_token = md5($domain_id.$date);
    $calculated_token = base64_encode(strtoupper(md5($domain_id.$date )));
    return $calculated_token;
  }

  public function getWebServiceClient(string $url) {
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
    return new SoapClient($url,$params);
  }

    public function getSaldo() {
        $url = "http://190.216.224.53:8080/wsServiciosSociosCCC2/wsSociosCCC.asmx?WSDL";
        try{
            $client = $this->getWebServiceClient($url);
            $user = auth()->user()->username;
            $response = $client->getSaldoXML([
              'group_id' => $user,
              'token' => $this->getToken(),
            ])->GetSaldoXMLResult;
            $i = 0;
            $newArray = array();
            foreach ($response as $key => $value) {
              if ($i==1) {
                $myxml = simplexml_load_string($value);				
                $registros= $myxml->NewDataSet->Table;
                $arrlength = @count($registros);
                for($x = 0; $x < $arrlength; $x++) {
                  array_push($newArray, $registros[$x]);
                }
              }
              $i++;
            }
            return $newArray;
        }
        catch(SoapFault $fault) {
            echo '<br>'.$fault;
        }
  }

  public function getUnpaidInvoices() {
    $url = "http://190.216.224.53:8080/wsServiciosSociosCCC3/wsSociosCCC.asmx?WSDL";
    try{
        $client = $this->getWebServiceClient($url);
        $user = auth()->user()->username;
        $response = $client->GetSaldoDetalladoXML([
            'group_id' => $user,
            'token' => $this->getToken(),
        ])->GetSaldoDetalladoXMLResult;
        $i = 0;
        $newArray = array();
        foreach ($response as $key => $value) {
            if ($i==1) {
            $myxml = simplexml_load_string($value);				
            $registros= $myxml->NewDataSet->Table;
            $arrlength = @count($registros);
            $acumulado = 0;
            for($x = 0; $x < $arrlength; $x++) {
                $monto = $registros[$x]->total_fac;
                $acumulado = bcadd($acumulado, $monto, 2);
                $registros[$x]->acumulado = $acumulado; 
                array_push($newArray, $registros[$x]);
            }
            }
            $i++;
        }
        return response()->json([
            'success' => true,
            'data' => $newArray,
            'total' => $acumulado
        ]);;
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
  }

  public function getReportedPayments() {
    $url = "http://190.216.224.53:8080/wsServiciosSociosCCC3/wsSociosCCC.asmx?WSDL";
    try{
        $client = $this->getWebServiceClient($url);
        $user = auth()->user()->username;
        $response = $client->GetReportePagosXML([
            'group_id' => $user,
            'token' => $this->getToken(),
        ])->GetReportePagosXMLResult;
        $i = 0;
        $newArray = array();
        foreach ($response as $key => $value) {
            if ($i==1) {
            $myxml = simplexml_load_string($value);				
            $registros= $myxml->NewDataSet->Table;
            $arrlength = @count($registros);
            for($x = 0; $x < $arrlength; $x++) {
                array_push($newArray, $registros[$x]);
            }
            }
            $i++;
        }
        return $newArray;
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
  }

}