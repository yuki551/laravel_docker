<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use App\Models\User;



class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        // $data = Post::all();
        $data2 = Client::all();
        $data = Post::select(
            'posts.*',
            'users.name as user_name',
            'client_a.name as client_name_am',
            'client_p.name as client_name_pm',
            'teams.name as team_name',
            'users.role_id as role_id'
        )
            ->join('users', 'posts.user', '=', 'users.id')
            ->join('teams', 'posts.team', '=', 'teams.id')
            ->leftjoin('clients as client_a', 'posts.client_am', '=', 'client_a.id')
            ->leftjoin('clients as client_p', 'posts.client_pm', '=', 'client_p.id')
            ->join('roles', 'roles.role_id', '=', 'users.role_id')
            ->orderBy('posts.updated_at', 'asc')
            ->get();

        $conf = config('setting.status');

        return Inertia::render('dashboard', ['data' => $data, 'conf' => $conf, 'data2' => $data2]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'user' => ['required'],
            'team' => ['required'],
            'summary_am' => ['required'],
            'client_am' => ['required'],
            'contents_am' => ['required'],
            'summary_pm' => ['required'],
            'client_pm' => ['required'],
            'contents_pm' => ['required'],
        ])->validate();

        Post::create($request->all());

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {

        // validator の clientを外す、statusを付け足す 02/02
        Validator::make($request->all(), [
            'user' => ['required'],
            'team' => ['required'],
            'summary_am' => ['required'],
            // 'client_am' => ['required'],
            'contents_am' => ['required'],
            'summary_pm' => ['required'],
            // 'client_pm' => ['required'],
            'contents_pm' => ['required'],
            'status' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Post::find($request->input('id'))->update($request->all());
            return redirect()->back()
                ->with('message', '更新しました。');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Post::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
