<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;   // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index()
    {
        $data = [];
        if(\Auth::check()){ // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // タスク一覧を取得
            $tasks = $user->tasks()->get();
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        
        // welcomeビューでそれらを表示
        return view('welcome',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;
        
        // タスク再生ビューを表示
        return view('tasks.create',[
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $this->validate($request,[
            'status' => 'required | max:10',
            'content' => 'required | max:255',
        ]);
        
        // 認証済みユーザ(閲覧者)の投稿としてタスクを作成
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    // getでtasks/（任意のid)にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // タスク詳細ビューでそれを表示
        return view('tasks.show',[
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    // getでtasks/(任意のid)/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // タスク編集ビューでそれを表示
        return view('tasks.edit',[
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    // putまたはpatchでtasks/(任意のid)にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // バリデーション
        $this->validate($request,[
            'status' => 'required | max:10',
            'content' => 'required | max:255',
        ]);
        
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスクを更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    // deleteでtasks/(任意のid)にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = \App\Task::findOrFail($id);
        
        // 認証済みユーザ(閲覧者)がその投稿の所有者である場合は、タスクを削除
        if(\Auth::id() === $task->user_id){
            $task->delete();
        }
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
