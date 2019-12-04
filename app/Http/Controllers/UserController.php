<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\GenericSolution\GenericControllers\ExportableControllerMixin;
use App\GenericSolution\GenericModels\ExportUtility\GenericExport;
use App\Models\Leave\AllocatedLeaveTypes;
class UserController extends Controller
{
    use ExportableControllerMixin;
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        GenericExport::$ExportableModel = new AllocatedLeaveTypes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->search) {
            return $this->filter($request);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $result = $this->user->storeResource($request);
//        return (is_object(json_decode($result))) === false ?  $result :  $result);
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    public function filter($request) {
        if ($request->name) {
            $user = User::where('name', '=', $request->name)->first();
            if ($user) {
                return response()->json(['message' => 'User found'], 200);
            } else {
                return response()->json(['message' => 'Resource not found'], 404);
            }
        } else if ($request->email) {
            $user = User::where('email', '=', $request->email)->first();
            if ($user) {
                return response()->json(['message' => 'User found'], 200);
            } else {
                return response()->json(['message' => 'Resource not found'], 404);
            }
        }
        return response()->json(['message' => 'Resource not found'], 404);
    }
}
