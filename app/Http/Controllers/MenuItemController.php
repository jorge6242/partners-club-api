<?php

namespace App\Http\Controllers;

use App\MenuItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class MenuItemController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index(Request $request)
    // {
    //     $banks = $this->service->index($request->query('perPage'));
    //     return response()->json([
    //         'success' => true,
    //         'data' => $banks
    //     ]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $data = MenuItem::query()->select([     
            'id',
            'name',
            'description', 
            'slug', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id'])->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $bankRequest = $request->all();
    //     $bank = $this->service->create($bankRequest);
    //     return $bank;
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $bank = $this->service->read($id);
    //     if($bank) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $bank
    //         ]);
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $bankRequest = $request->all();
    //     $bank = $this->service->update($bankRequest, $id);
    //     if($bank) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $bank
    //         ]);
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $bank = $this->service->delete($id);
    //     if($bank) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $bank
    //         ]);
    //     }
    // }

    // /**
    //  * Get the specified resource by search.
    //  *
    //  * @param  string $term
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function search(Request $request) {
    //     $bank = $this->service->search($request);
    //     if($bank) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $bank
    //         ]);
    //     }
    // }

    //     /**
    //  * Get the specified resource by search.
    //  *
    //  * @param  string $term
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function getByLocation(Request $request) {
    //     $data = $this->service->getByLocation($request['id']);
    //     if($data) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $data
    //         ]);
    //     }
    // }
}
