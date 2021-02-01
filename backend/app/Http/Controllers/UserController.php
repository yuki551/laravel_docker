<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Team;
use App\Models\Role;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * userlist, 従業員一覧表示
     */
    public function index()
    {

        $data = User::select(
            'users.*',
            'teams.name as team_name',
            'roles.name as role_name')
            ->join('teams', 'users.current_team_id', '=', 'teams.id')
            ->join('roles', 'users.role_id', '=', 'roles.role_id')
            ->where('users.role_id', '>=', 3)
            ->orderBy('users.current_team_id', 'asc')
            ->orderBy('users.role_id', 'asc')
            ->get();

        $data2 = Team::all();

        $conf = config('setting.status');


        return Inertia::render('User/Index', ['data' => $data, 'data2' => $data2, 'conf' => $conf]);
    }



    /**
     * create
     * 社員登録
     *
     */
    public function create(){


        $dataTeam = Team::all();
        $dataRole = Role::all();
        $user = Auth::user();

        $flag = session()->get('confirm');
        session()->forget('confirm');

        if($flag==1){


            $team_name = Team::find(session()->get('current_team_id'))->name;
            $role_name = Role::where('role_id', '=', session()->get('role_id'))->first()->name;
            $auth_id = session()->get('auth_id');
            if($auth_id==1){
                $auth_name = '有り';
            }else{
                $auth_name = '無し';
            }

            $confirmuser = new User();
            $confirmuser = [
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'password' => session()->get('password'),
                'current_team_id' => session()->get('current_team_id'),
                'role_id' => session()->get('role_id'),
                'auth_id' => session()->get('auth_id'),
                'team_name' => $team_name,
                'role_name' => $role_name,
                'auth_name' => $auth_name,
                'confirm' => $flag,
            ];

            session()->forget('confirm', 'id', 'name', 'email', 'password', 'current_team_id', 'role_id', 'auth_id');



            return Inertia::render('User/Confirm', ['confirmuser' => $confirmuser]);

        }else{
            session()->forget('confirm', 'id', 'name', 'email', 'password', 'current_team_id', 'role_id', 'auth_id');

            if ($user['auth_id'] == 1) {

                return Inertia::render('User/Create', ['dataTeam' => $dataTeam,'dataRole' => $dataRole]);
            } else {
                return redirect('/users')->with('message', '現在の権限では社員登録にはアクセスできません。');
            }
        }

    }


    /**
     * edit
     * 社員編集
     *
     */
    public function edit($id){

        $auth = Auth::user();



        $flag = session()->get('confirm');

        session()->forget('confirm');

        if($flag==2){

            $team_name = Team::find(session()->get('current_team_id'))->name;
            $role_name = Role::where('role_id', '=', session()->get('role_id'))->first()->name;

            $auth_id = session()->get('auth_id');
            if($auth_id==1){
                $auth_name = '有り';
            }else{
                $auth_name = '無し';
            }

            $confirmuser = new User();
            $confirmuser = [
                'id' => session()->get('id'),
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'current_team_id' => session()->get('current_team_id'),
                'role_id' => session()->get('role_id'),
                'auth_id' => session()->get('auth_id'),
                'team_name' => $team_name,
                'role_name' => $role_name,
                'auth_name' => $auth_name,
                'confirm' => $flag,
            ];

            session()->forget('confirm', 'id', 'name', 'email', 'current_team_id', 'role_id', 'auth_id');


            return Inertia::render('User/Confirm', ['confirmuser' => $confirmuser]);

        }else{
            session()->forget('confirm', 'id', 'name', 'email', 'password', 'current_team_id', 'role_id', 'auth_id');

            if ($auth['auth_id'] == 1) {

                $dataTeam = Team::all();
                $dataRole = Role::all();
                $user = User::find($id);
                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    // 'password' => $user->password,
                    'current_team_id' => $user->current_team_id,
                    'role_id' => $user->role_id,
                    'auth_id' => $user->auth_id,
                ];
                return Inertia::render('User/Edit', ['data' => $data, 'dataTeam' => $dataTeam,'dataRole' => $dataRole]);
            } else {
                return redirect('/users')->with('message', '現在の権限では社員編集にはアクセスできません。');
            }
        }
    }



    public function show($id){

        // $user = User::select(
        //     'users.*',
        //     'teams.name as team_name',
        //     'roles.name as role_name')
        //     ->join('teams', 'users.current_team_id', '=', 'teams.id')
        //     ->join('roles', 'users.role_id', '=', 'roles.role_id')
        //     ->where('users.id', '=', $id)
        //     ->get();
        $user = User::find($id);
        if($user->auth_id == 1){
            $auth_name = '有り';
        }else{
            $auth_name = '無し';
        }

        $team_name = Team::find($user->current_team_id)->name;
        $role_name = Role::where('role_id', '=', $user->role_id)->first()->name;


        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            // 'password' => $user->password,
            'current_team_id' => $user->current_team_id,
            'team_name' => $team_name,
            'role_id' => $user->role_id,
            'role_name' => $role_name,
            'auth_id' => $user->auth_id,
            'auth_name' => $auth_name,
        ];

        $dataTeam = Team::all();
        $dataRole = Role::all();

        return Inertia::render('User/Show', ['data' => $data, 'dataTeam' => $dataTeam,'dataRole' => $dataRole]);
    }

    public function destroy($id){
        $user = User::find($id);
        $name = $user->name;
        $user->delete();
        return redirect('/users')->with('message', $name.'さんのユーザーアカウントは削除されました。');

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
            'auth_id' => ['required'],
        ])->validate();



        $user = new User();
        $newpass = Hash::make($request->password);


        $user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $newpass,
            'current_team_id' => $request->current_team_id,
            'role_id' => $request->role_id,
            'auth_id' => $request->auth_id,
        ]);

        $request->session()->forget('confirm', 'name', 'email', 'password', 'current_team_id', 'role_id', 'auth_id');

        return redirect()->route('user.index')
                ->with('message', $request->name.'さんが登録されました。');
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [

            'name' => ['required'],
            'email' => ['required'],
            // 'password' => ['required'],
            'current_team_id' => ['required'],
            'role_id' => ['required'],
            'auth_id' => ['required'],

        ])->validate();

        $user = new User();
        $id = $request->id;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => $request->password,
            'current_team_id' => $request->current_team_id,
            'role_id' => $request->role_id,
            'auth_id' => $request->auth_id,
        ];
        $user->where('id', $id)->update($data);


        return redirect()->route('user.index')
                ->with('message', $request->name.'さんが更新されました。');
    }

    public function confirm(Request $request)
    {

        $request->session()->put('confirm', $request->confirm);

        $dataTeam = Team::all();
        $dataRole = Role::all();

        if($request->confirm == 1){

            Validator::make($request->all(), [
                'name' => ['required'],
                'email' => ['required'],
                'password' => ['required'],
                'current_team_id' => ['required'],
                'role_id' => ['required'],
                'auth_id' => ['required'],
            ])->validatewithBag("userCreate");

            $request->session()->put('name' , $request->name);
            $request->session()->put('email' , $request->email);
            $request->session()->put('password' , $request->password);
            $request->session()->put('current_team_id' , $request->current_team_id);
            $request->session()->put('role_id' , $request->role_id);
            $request->session()->put('auth_id' , $request->auth_id);
            return Inertia::render('User/Create');

        }elseif($request->confirm == 2){
            Validator::make($request->all(), [
                'id' => ['required'],
                'name' => ['required'],
                'email' => ['required'],
                'current_team_id' => ['required'],
                'role_id' => ['required'],
                'auth_id' => ['required'],
            ])->validatewithBag("userUpdate");

            $request->session()->put('id' , $request->id);
            $request->session()->put('name' , $request->name);
            $request->session()->put('email' , $request->email);
            $request->session()->put('current_team_id' , $request->current_team_id);
            $request->session()->put('role_id' , $request->role_id);
            $request->session()->put('auth_id' , $request->auth_id);
            $data = [
                'id' => $request->id,
                'name' => $request->name,
                'email' => $request->email,
                // 'password' => $request->password,
                'current_team_id' => $request->current_team_id,
                'role_id' => $request->role_id,
                'auth_id' => $request->auth_id,

            ];
            return Inertia::render('User/Edit', ['data' => $data, 'dataTeam' => $dataTeam,'dataRole' => $dataRole]);

        }elseif($request->confirm == 3){
            return redirect()->route('user.index')
                ->with('message', 'なんらかのエラー');
        }else{
            return redirect()->route('user.index')
            ->with('message', 'なんらかのエラー');
        }

    }

}
