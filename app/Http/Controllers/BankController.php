<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;
use App\Services\BankService;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Requests\BankValidator;

class BankController extends Controller
{
    public function __construct(BankService $bankService)
	{
		$this->bankService = $bankService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->can('acl.maestro-banco-ver')) {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos'
            ])->setStatusCode(400);
        }
        $banks = $this->bankService->index($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $banks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('acl.maestro-banco-crear')) {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos'
            ])->setStatusCode(400);
        }
        $bankRequest = $request->all();
        $bank = $this->bankService->create($bankRequest);
        return $bank;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!auth()->user()->can('acl.maestro-banco-ver')) {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos'
            ])->setStatusCode(400);
        }
        $bank = $this->bankService->read($id);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
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
        if(!auth()->user()->can('acl.maestro-banco-editar')) {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos'
            ])->setStatusCode(400);
        }
        $bankRequest = $request->all();
        $bank = $this->bankService->update($bankRequest, $id);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
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
        if(!auth()->user()->can('acl.maestro-banco-borrar')) {
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos'
            ])->setStatusCode(400);
        }
        $bank = $this->bankService->delete($id);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
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
        $bank = $this->bankService->search($request);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }

    public function generatePdf()
    {        

        $bank = Bank::all();
        $data = [
            'data' => $bank
        ];
        $pdf = PDF::loadView('reports/expiration_cards', $data);
        return $pdf->download('archivo.pdf');
    }
}
