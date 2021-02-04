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

class TeamListController extends Controller
{
    // team一覧表示コントローラー作成 02/02
    public function index()
    {
        $data = Team::all();
        $user = Auth::user();

        $conf = config('setting.status');

        return Inertia::render('teamlists', ['data' => $data, 'conf' => $conf]);
    }

    /**
     * 部署編集コントローラ02/02
     */
    public function edit($id){

        $auth = Auth::user();
        if ($auth['auth_id'] == 1) {

            $team = Team::find($id);
            $data = [
                'id' => $team->id, 
                'name' => $team->name,
            ];
            return Inertia::render('teamedit', ['data' => $data]);
        } else {
            return redirect('/users')->with('message', '現在の権限では社員編集にはアクセスできません。');
        }
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
        ])->validate();

        $team = new Team();
        $id = $request->id;

        $data = [
            'name' => $request->name,
        ];
        $team->where('id', $id)->update($data);

        return redirect()->route('teamlist.index')
                ->with('message', $request->name.'が更新されました。');
    }



}
