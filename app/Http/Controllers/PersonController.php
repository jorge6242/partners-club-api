<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PersonService;
use Barryvdh\DomPDF\Facade as PDF;

class PersonController extends Controller
{
    public function __construct(PersonService $service)
	{
		$this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persons = $this->service->index();
        return response()->json([
            'success' => true,
            'data' => $persons
        ]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $persons = $this->service->reportAll();
        return $persons;
        $data = [
            'data' => $persons
        ];
        $pdf = PDF::loadView('reports/expiration_cards', $data);
        return $pdf->download('archivo.pdf');
    }


        /**
     * PDF Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function partnerReport()
    {
        $persons = $this->service->reportAll();
        $data = [
            'data' => $persons
        ];
        
        $pdf = PDF::loadView('reports/partner', $data);
        return $pdf->download('archivo.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personRequest = $request->all();
        $person = $this->service->create($personRequest);
        return $person;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = $this->service->read($id);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $personRequest = $request->all();
        $person = $this->service->update($personRequest, $id);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = $this->service->delete($id);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $person = $this->service->search($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }


    /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchPersonsToAssign(Request $request) {
        $person = $this->service->searchPersonsToAssign($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

    /**
     * create relation type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignPerson(Request $request)
    {
        $personRequest = $request->all();
        $person = $this->service->assignPerson($personRequest);
        return $person;
    }

        /**
     * Get the specified family by person
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchFamilyByPerson(Request $request) {
        $person = $this->service->searchFamilyByPerson($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getReportByPartner(Request $request)
    {
        $requestBody = $request->all();
        $partner = $this->service->getReportByPartner($requestBody['id']);
        $data = [
            'data' => $partner
        ];
        
        $pdf = PDF::loadView('reports/partner', $data);
        return $pdf->download('archivo.pdf');
    }
}
