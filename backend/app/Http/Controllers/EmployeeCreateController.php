<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Team;
use App\Models\Role;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class EmployeeCreateController extends Controller
{
    public function index()
    {
        $dataTeam = Team::all();
        $dataRole = Role::all();
        return Inertia::render('employee_create', ['dataTeam' => $dataTeam,'dataRole' => $dataRole]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(UserStoreRequest $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'current_team_id' => ['required'],
            'role_id' => ['required'],
            'auth_id' => ['required'],
        ])->validateWithBag('userCreate');

        // $request->user()->fill([
        //     'password' => Hash::make($request->newPassword)
        // ])->save();


        $user = new User();
        // var_dump($data);
        $newpass = Hash::make($request->password);
        
        $user->create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => $newpass, 
            'current_team_id' => $request->current_team_id, 
            'role_id' => $request->role_id,
            'auth_id' => $request->auth_id,
        ]);

        return redirect()->route('user.index')
            ->with('message', '登録されました。');
    }
}
