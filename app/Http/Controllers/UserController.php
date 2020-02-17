<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(UserService $userService)
	{
		$this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->userService->index();
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function availableToTeam()
    {
        $user = $this->userService->availableToTeam();
        return response()->json([
            'success' => true,
            'data' => $user
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
        $userRequest = $request->all();
        if ($this->userService->checkUser($request['email'])) {
            return response()->json([
                'success' => false,
                'message' => 'User already exist'
            ])->setStatusCode(400);
        }
        $user = $this->userService->create($userRequest);
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ])->setStatusCode(200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userService->read($id);
        if($user) {
            return response()->json([
                'success' => true,
                'data' => $user
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
        $userRequest = $request->all();
        $user = $this->userService->update($userRequest, $id);
        if($user) {
            return response()->json([
                'success' => true,
                'data' => $user
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
        $user = $this->userService->delete($id);
        if($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }
    }
}
