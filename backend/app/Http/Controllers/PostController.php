<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\Team;
use App\Models\User;

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
     * PostlistsのindexをPostのindexに移動 02/02
     *
     * @return Response
     */
    public function index()
    {
        $data = Post::select(
            'posts.id',
            'users.name as user_name',
            'posts.created_at',
            'summary_am',
            'client_a.name as client_name_am',
            'contents_am',
            'summary_pm',
            'client_p.name as client_name_pm',
            'contents_pm',
            'teams.name as team_name')
            ->join('users', 'posts.user', '=', 'users.id')
            ->join('teams', 'posts.team', '=', 'teams.id')
            ->leftjoin('clients as client_a', 'posts.client_am', '=', 'client_a.id')
            ->leftjoin('clients as client_p', 'posts.client_pm', '=', 'client_p.id')
            ->where('status', '2')
            ->get();

        $user = Auth::user();
        // var_dump($data);

        // var_dump($user["role_id"]);
        $conf = config('setting.status');

        return Inertia::render('Post/Index', ['data' => $data, 'conf' => $conf]);
    }


    /**
     * indexの内容をcreateへ移動 02/02
     */
    public function create(){


        //ここから確認画面用に編集 02/02
        if(session()->has('confirm')){
            $flag = session()->get('confirm');
            session()->forget('confirm');
        }else{
            $flag = 0;
        }
        if($flag==1){
            // 一度confirmを通った場合：確認画面表示


            // get の後に->value('name')があったのを削除、下のconfirmpost内でname呼び出し

            $confirmpost = new Post();

            $confirmpost = [
                'user' => session()->get('user'),
                'team' => session()->get('team'),
                'date' => session()->get('date'),
                'client_am' => session()->get('client_am'),
                'summary_am' => session()->get('summary_am'),
                'contents_am' => session()->get('contents_am'),
                'client_pm' => session()->get('client_pm'),
                'summary_pm' => session()->get('summary_pm'),
                'contents_pm' => session()->get('contents_pm'),
                'status' => session()->get('status'),
            ];

            $username = User::find(session()->get('user'));
            $confirmpost += [
                'username' => $username->name,
            ];

            // sessionにある場合にconfirmpostに追加
            if(session()->has('team')){
                $teamname = Team::find(session()->get('team'));
                $confirmpost += [
                    'teamname' => $teamname->name,
                ];
            }

            if(session()->has('client_am')){
                $client_am_name = Client::find(session()->get('client_am'));
                $confirmpost += [
                    'client_am_name' => $client_am_name->name,
                ];
            }else{
                $confirmpost += [
                    'client_am_name' => "登録なし",
                ];
            }

            if(session()->has('client_pm')){
                $client_pm_name = Client::find(session()->get('client_pm'));
                $confirmpost += [
                    'client_pm_name' => $client_pm_name->name,
                ];
            }else{
                $confirmpost += [
                    'client_pm_name' => "登録なし",
                ];
            }




            session()->forget(['confirm', 'user', 'team', 'date', 'client_am', 'summary_am', 'contents_am', 'client_pm', 'summary_pm', 'contents_pm', 'status']);

            return Inertia::render('Post/Confirm', ['confirmpost' => $confirmpost]);

        }else{
            // 初回 or validation時のフォーム表示

            // olddataを追加 02/03

            $user = Auth::user();
            $data = Client::all();

            $olddata = [
                'oldclient_am' => old('client_am'),
                'oldsummary_am' => old('summary_am'),
                'oldcontents_am' => old('contents_am'),
                'oldclient_pm' => old('client_pm'),
                'oldsummary_pm' => old('summary_pm'),
                'oldcontents_pm' => old('contents_pm'),
            ];

            session()->forget(['confirm', 'user', 'team', 'date', 'client_am', 'summary_am', 'contents_am', 'client_pm', 'summary_pm', 'contents_pm', 'status']);


            if ($user['role_id'] == 3) {
                return redirect('/dashboard')->with('message', '現在の権限では日報登録にはアクセスできません。');
            } else if ($user['role_id'] == 5 || $user['role_id'] == 10) {
                // olddataを追加 02/03
                return Inertia::render('Post/Create', ['data' => $data, 'olddata' => $olddata]);
            } else {
                return redirect('/dashboard')->with('message', '現在の権限では日報登録にはアクセスできません。');
            }
        }
        // ここまで 02/02
        // posts.vue
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        //user id と team id が整合性取れる場合のみ入力できる様にしたい

        // var_dump($request); をコメントアウト。02/02

        // $post = new Post();

        // $post->create([
        //     'user' => $request->user,
        //     'team' => $request->team,
        //     'client_am' => $request->client_am,
        //     'summary_am' => $request->summary_am,
        //     'contents_am' => $request->contents_am,
        //     'client_pm' => $request->client_pm,
        //     'summary_pm' => $request->summary_pm,
        //     'contents_pm' => $request->contents_pm,
        //     'status' => $request->status,
        // ]);

        Post::create($request->all());

        return redirect('post.create')
            ->with('message', '日報を提出しました。');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            // 'title' => ['required'],
            // 'body' => ['required'],
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


    /**
     * 日報登録時の確認用、02/02
     */
    public function confirm(Request $request){

        $request->session()->put('confirm', $request->confirm);


        // 02/03 validation変更
        $validator = Validator::make($request->all(), [
            'user' => ['required'],
            'team' => ['required'],
            // 'date' => ['required'],
            'summary_am' => ['required'],
            'contents_am' => ['required'],
            'summary_pm' => ['required'],
            'contents_pm' => ['required'],
            // 'client_pm' => ['required'],
        ],
        [
            'summary_am.required' => '午前の業務について記載がありません。',
            'contents_am.required' => '午前の業務内容についての記載がありません。',
            'summary_pm.required' => '午後の業務について記載がありません。',
            'contents_pm.required' => '午後の業務内容についての記載がありません。',
        ]);


        // バリデーションエラーだった場合
        if ($validator->fails()) {
            session()->forget(['confirm', 'user', 'team', 'date', 'client_am', 'summary_am', 'contents_am', 'client_pm', 'summary_pm', 'contents_pm', 'status']);

            return redirect('post.create')
                ->withErrors($validator)
                ->withInput();
        }

        // // // validationを変更
        // Validator::make(
        //     $request->all(),
        //     [
        //         'user' => ['required'],
        //         'team' => ['required'],
        //         // 'date' => ['required'],
        //         'summary_am' => ['required'],
        //         'contents_am' => ['required'],
        //         'summary_pm' => ['required'],
        //         'contents_pm' => ['required'],
        //         // 'client_pm' => ['required'],
        //         'status' => ['required'],
        //     ],
        //     [
        //         'summary_am.required' => '午前の業務について記載がありません。',
        //         'contents_am.required' => '午前の業務内容についての記載がありません。',
        //         'summary_pm.required' => '午後の業務について記載がありません。',
        //         'contents_pm.required' => '午後の業務内容についての記載がありません。',
        //     ],
        // )->validate();


        $request->session()->put('user' , $request->user);
        $request->session()->put('team' , $request->team);
        $request->session()->put('date' , $request->date);
        $request->session()->put('client_am' , $request->client_am);
        $request->session()->put('summary_am' , $request->summary_am);
        $request->session()->put('contents_am' , $request->contents_am);
        $request->session()->put('client_pm' , $request->client_pm);
        $request->session()->put('summary_pm' , $request->summary_pm);
        $request->session()->put('contents_pm' , $request->contents_pm);
        $request->session()->put('status' , $request->status);
        $request->session()->put('confirm' , $request->confirm);


        $data = Client::all();


        return Inertia::render('Post/Create', ['data' => $data]);

    }

    public function getconfirm(){
        return redirect()->route('post.create');
    }

}
