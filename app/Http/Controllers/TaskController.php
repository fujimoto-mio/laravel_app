<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Taskテーブルのデータを全部取得する
        // status がfalseのときのデータをすべて取得する
        $tasks = Task::where('status', false)->get();
        return view('tasks.index', ['tasks'=> $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //バリデーションのリールを記載
        $rules = [
            'task_name' => 'required|max:100',
        ];
        $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];

        Validator::make($request->all(), $rules, $messages)->validate();

        $task = new Task;

        //モデル->カラム名 = 値 で、データを割り当てる
        $task->name = $request->input('task_name');

        $task->save();

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::find($id);
        return view('tasks.edit', ['task'=> $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //「編集する」と完了ボタンをおしたとき ifで分ける
        if ($request->status === null) {

            //バリデーションです
            $rules = [
                'task_name' => 'required|max:100',
            ];
            $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];
            Validator::make($request->all(), $rules, $messages)->validate();

            //該当のタスクを検索取得する
            $task = Task::find($id);

            //モデル->カラム名 = 値 で、データnamwを割り当てる（更新する）
            $task->name = $request->input('task_name');

            $task->save();
        }else {
            //「完了」ボタンを押したとき

            //該当のタスクを検索
            $task = Task::find($id);

            // statusをtrueにして完了に変える。
            //モデル->カラム名 = 値 で、データを割り当てる
            $task->status = true; //true:完了、false:未完了

            $task->save();
        }

        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
        return redirect('/tasks');
    }
}
