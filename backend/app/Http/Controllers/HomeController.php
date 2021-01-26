<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;


// user情報取得用
use Illuminate\Support\Facades\Auth;


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
        $data = Post::select(
            'posts.*',
            'users.name as user_name',
            'client_a.name as client_name_am',
            'client_p.name as client_name_pm',
            'teams.name as team_name',
            )
            ->join('users', 'posts.user', '=', 'users.id')
            ->join('teams', 'posts.team', '=', 'teams.id')
            ->join('clients as client_a', 'posts.client_am', '=', 'client_a.id')
            ->join('clients as client_p', 'posts.client_pm', '=', 'client_p.id')
            ->get();

        $user = Auth::user();
        // var_dump($data);

        // var_dump($user["role_id"]);
        $conf = config('setting.status');

        return Inertia::render('dashboard', ['data' => $data, 'conf' => $conf]);

        //管理者用ページ
        // if ($user["role_id"] == 1) {
        //     return Inertia::render('admin', ['data' => $data, 'conf' => $conf]);
        // } else {
        //     return Inertia::render('dashboard', ['data' => $data, 'conf' => $conf]);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'summary_am' => ['required'],
            'contents_am' => ['required'],
        ])->validate();

        Post::create($request->all());

        return redirect()->back()
            ->with('message', 'Post Created Successfully.');
    }
    public function retryPost(Request $request)
    {
        Validator::make($request->all(), [
            'comment' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            Post::find($request->input('id'))->update($request->all());
            return redirect()->back()
                ->with('message', 'Post');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
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

        if ($request->has('id')) {
            Post::find($request->input('id'))->update($request->all());
            return redirect()->back()
                ->with('message', 'Post Updated Successfully.');
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
