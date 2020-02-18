<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PersonService;

class PersonController extends Controller
{
    public function __construct(PersonService $personService)
	{
		$this->personService = $personService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persons = $this->personService->index();
        return response()->json([
            'success' => true,
            'data' => $persons
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
        $personRequest = $request->all();
        $person = $this->personService->create($personRequest);
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
        $person = $this->personService->read($id);
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
        $person = $this->bankService->update($personRequest, $id);
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
        $person = $this->personService->delete($id);
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
        $person = $this->personService->search($request);
        if($person) {
            return response()->json([
                'success' => true,
                'data' => $person
            ]);
        }
    }
}
