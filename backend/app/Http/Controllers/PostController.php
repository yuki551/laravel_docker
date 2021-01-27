<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
// config呼び出し用
// var_dump(config('setting.hierarchy'));
// var_dump(config('setting.status'));

class PostController extends Controller
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
        $user = Auth::user();
        $data = Post::all();
        $data2 = Client::all();

        if ($user['role_id'] == 3) {
            return redirect('/dashboard')->with('message', '現在の権限では日報登録にはアクセスできません。');
        } else if ($user['role_id'] == 5 || $user['role_id'] == 10) {
            return Inertia::render('posts', ['data' => $data, 'data2' => $data2]);
        } else {
            return redirect('/dashboard')->with('message', '現在の権限では日報登録にはアクセスできません。');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        //user id と team id が整合性取れる場合のみ入力できる様にしたい
        Validator::make($request->all(), [
            'user' => ['required'],
            'team' => ['required'],
            // 'date' => ['required'],
            'summary_am' => ['required'],
            'contents_am' => ['required'],
            'client_am' => ['required'],
            'summary_pm' => ['required'],
            'contents_pm' => ['required'],
            'client_pm' => ['required'],
            'status' => ['required'],
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
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
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
