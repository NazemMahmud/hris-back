<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\Leave\LeaveBalance;
use App\Models\Setup\Group;
use App\Models\Setup\Position;
use App\Models\Setup\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Post as PostResource;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
//use App\Model\Post;
use Hash;
use Illuminate\Support\Facades\Validator;
use App\Manager\RedisManager\RedisManager;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->middleware('auth:api', ['except' => ['login', 'register', 'getusers', 'employee_register']]);
    }

    /**
     * @param Request $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
         if (RedisManager::exists($request->name, $request->password)) {
              return RedisManager::getUser($request->name, $request->password);
         } else {
            $credentials = $request->only('name', 'password');
            if ($token = $this->guard()->attempt($credentials)) {
                $access_token = $this->respondWithToken($token);

                $user = Auth::user();
                $user->access_token = $access_token;
                return $user = new UserResource($user);
                return RedisManager::userStore($request->name, $request->password, $user);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['success' => 'User created successfully']);
    }

    public function employee_register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name'=> 'required|unique:users',
            'email'=> 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'staff_id' => 'required',
            'group_id' => 'required'
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);
        $user = User::where('staff_id', '=', $request->staff_id)->first();
        if (empty($user)){
            $user = new User();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->staff_id = $request->staff_id;
        $user->group_id = $request->group_id;
        $user->password = bcrypt($request->password);
        $user->save();

        $employee = Employee::find($request->staff_id);
//        $position = Position::find($request->position_id);
        $group = Group::find($request->group_id);
//        $role = Role::find($request->role_id);

        //Leave balance initialize when new employee register
        LeaveBalance::EmployeeLeaveBalanceInitialize($request->staff_id, $user->name);

        $data = array(
            "employee_name" => $employee->employeeName,
            'user_name' => $user->name,
//            'position_name' => $position->name,
            'group_name' => $group->name,
//            'role_name' => $role->name,
            'message' => 'User Created Successfully'
        );

        $userData = array( 'data' => $data);

        return $userData;
    }

    /**
     * @return UserResource
     */
    public function me()
    {
        return new UserResource(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // dd('1');
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);
        return $this->respondWithToken($newToken);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    public function getusers() {
        $users = User::get();
        $allUsers = array();
        foreach ($users as $user){
            $employee_name = Employee::select('employeeName')->where('id', $user->staff_id)->first();
            $user_name = $user->name;
            $position_name = Position::select('name')->where('id', $user->position_id)->first();
            $group_name = Group::select('name')->where('id', $user->group_id)->first();
            $role_name = Role::select('name')->where('id', $user->role_id)->first();

            $employeeName = (isset($employee_name->employeeName))? $employee_name->employeeName : '';
            $positionName = (isset($position_name->name))? $position_name->name : '';
            $groupName = (isset($group_name->name))? $group_name->name:'';
            $roleName = (isset($role_name->name))? $role_name->name : '';

            $allUsers[] = array(
                'employee_name' => $employeeName,
                'user_name' => $user_name,
                'position_name' => $positionName,
                'group_name' => $groupName,
                'role_name' => $roleName
            );
        }
        return $allUsers;
    }
}
