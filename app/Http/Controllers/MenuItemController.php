<?php

namespace App\Http\Controllers;

use App\MenuItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class MenuItemController extends Controller
{
    public function __construct(MenuItem $model)
	{
		$this->model = $model;
    }
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index(Request $request)
    {
        $data = $this->model->query()->select(          
            'id',
            'name', 
            'slug', 
            'description', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id')->paginate($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $data =$this->model->query()->select([     
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
     public function store(Request $request)
     {
         $attributes = $request->all();
         $data = $this->model->create($attributes);
         return response()->json([
            'success' => true,
            'data' => $data
        ]);
     }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show($id)
    {
        $bank =$this->model->find($id, [
            'id',
            'name', 
            'slug', 
            'description', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id',
            ]);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, $id)
    {
        $attributes = $request->all();
        $bank = $this->model->find($id)->update($attributes);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($id)
    {
        $data = $this->model->find($id)->delete();
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    // /**
    //  * Get the specified resource by search.
    //  *
    //  * @param  string $term
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function search(Request $request) {
        $search;
      if($request->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('description', 'like', '%'.$request->query('term').'%')
        ->paginate($request->query('perPage'));
      }
        if($search) {
            return response()->json([
                'success' => true,
                'data' => $search
            ]);
        }
    }

        //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function getParents(Request $request)
    {
        $data = $this->model->query()->select(['id', 'description'])->where('parent', '=', 0)->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
