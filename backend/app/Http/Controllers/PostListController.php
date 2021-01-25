<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

// user情報取得用
use Illuminate\Support\Facades\Auth;

// config呼び出し用
// var_dump(config('setting.hierarchy'));
// var_dump(config('setting.status'));

class PostListController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = User::leftjoin('posts', 'users.id', '=', 'posts.user')->where('status', '2')->get();

        $user = Auth::user();
        // var_dump($data);

        // var_dump($user["role_id"]);
        $conf = config('setting.status');

        return Inertia::render('postlists', ['data' => $data, 'conf' => $conf]);

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

        //user id と team id が整合性取れる場合のみ入力できる様にしたい
        Validator::make($request->all(), [
            'user' => ['required'],
            'team' => ['required'],
            // 'date' => ['required'],
            'summary_am' => ['required'],
            'contents_am' => ['required'],
            'summary_pm' => ['required'],
            'contents_pm' => ['required'],
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
