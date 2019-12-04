<?php

namespace App;

use App\Models\Employee\Employee;
use App\Models\Leave\LeaveBalance;
use App\Models\Setup\Group;
use App\Models\Setup\Position;
use App\Models\Setup\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;
    use LogsActivity;


    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_name', 'email', 'password',
    ];

    protected static $logAttributes = ['name', 'email', 'password'];
    protected static $logName = 'User Activity';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        $name = Employee::find($this->staff_id);
        return [
            'user_id' => $this->id,
            'staff_id' => $this->staff_id,
            'name' => $name->employeeName,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'group_id' => $this->group_id,
        ];
    }

    function storeResource($request)
    {
        $validator = Validator::make($request->all(), [
            'login_name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'position_id' => 'required',
            'group_id' => 'required',
            'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'staff_id' => 'required',
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->messages()], 400);

        $role = Role::find($request->role_id);
        if (empty($role)) return response()->json(['errors' => 'Invalid Role'], 500);

        $group = Group::find($request->group_id);
        if (empty($group)) return response()->json(['errors' => 'Invalid Group'], 500);

        $position = Position::find($request->position_id);
        if (empty($position)) return response()->json(['errors' => 'Invalid Position'], 500);

        $staff = Employee::find($request->staff_id);
        if (empty($staff)) return response()->json(['errors' => 'Invalid Employee'], 500);

        $resource = new User();

        $resource->login_name = $request->login_name;
        $resource->email = $request->email;
        $resource->group_id = $request->group_id;
        $resource->role_id = $request->role_id;
        $resource->position_id = $request->position_id;
        $resource->staff_id = $request->staff_id;
        $resource->password = bcrypt($request->password);

        $resource->save();
        //Leave balance initialize when new employee register
        LeaveBalance::EmployeeLeaveBalanceInitialize($resource->id, $resource->login_name);

        return $resource;
    }
}
