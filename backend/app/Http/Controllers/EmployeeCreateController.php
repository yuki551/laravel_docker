<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Team;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'current_team_id' => ['required'],
            'role_id' => ['required'],
        ])->validate();

        User::create($request->all());

        return redirect()->back()
            ->with('message', '登録されました。');
    }
}
