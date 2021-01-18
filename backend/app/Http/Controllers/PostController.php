<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Post::all();
        return Inertia::render('posts', ['data' => $data]);
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
