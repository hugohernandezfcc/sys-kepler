<?php

namespace App\Http\Controllers;

use App\Task;
use App\Subject;
use App\Group;
use App\ApplyTask;
use Auth;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('task', [
                'typeView'  => 'list',
                'records' => Task::all()
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        $tasks = Task::all();

        return $tasks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task', [
                'typeView' => 'form',
                'to_related' => Subject::all()->groupBy('area_id')
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->subject_id = $request->subject_id;
        $subject = Subject::find($request->subject_id);
        $task->area_id = $subject->area_id;
        $task->created_by = Auth::id();
        if ($task->save()) {
            return redirect('/task/show/' . $task->id);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeapplytask(Request $request)
    {
        sleep(1);
        $ranString = openssl_random_pseudo_bytes(6);
        $name = bin2hex($ranString);
        $applyTask = new ApplyTask();
        $applyTask->name = time().$name;
        $applyTask->task_id = $request->taskId;
        $applyTask->group_id = $request->groupId;
        $applyTask->by = Auth::id();
        if ($applyTask->save()) {
            //$this->enviarMail($applyExam);
            return Response()->json(array('result' => 'ok', 'codeTask' => $applyTask->name));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $taskId
     * @return \Illuminate\Http\Response
     */
    public function show($taskId)
    {
        return view('task', [
                'typeView' => 'view',
                'record' => Task::find($taskId),
                'to_related' => Group::all()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task->name = $request->get('name');

        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
