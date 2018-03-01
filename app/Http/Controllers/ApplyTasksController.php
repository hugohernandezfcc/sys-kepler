<?php

namespace App\Http\Controllers;

use App\Task;
use App\ApplyTask;
use App\Result;
use App\ResultItem;
use Auth;
use Illuminate\Http\Request;

class ApplyTasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * @param  \App\ApplyExam  $applyExamName
     * @return \Illuminate\Http\Response
     */
    public function taketask($applyExamName)
    {
        $takeTask = ApplyTask::where('name', '=', $applyExamName)->first();
        if ($takeTask !== null) {
            return view('takeeval', [
                'typeView' => 'taketask',
                'record' => Task::find($takeTask->task_id),
                ]
            ); 
        } else {
            return redirect('/404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeanswers(Request $request)
    {
        $task = Task::where('id', '=', $request->taskId)->first();
        $result = new Result();
        $result->id_record = $task->id;
        $result->name_record = $task->name;
        $result->type = 'result task';
        $result->by = Auth::id();
        if ($result->save()) {
            $taskAnswer = 'response'.$task->id;
            if ($request->$taskAnswer !== null) {
                $this->storeAnswerExam($request->$taskAnswer, $task->description, $result->id);
            }
        }
        return redirect('/home');
    }
    
    /**
     * Permite almacenar el detalle de cada respuesta
     * 
     * @param mixed $respuesta
     * @param mixed $question
     * @param integer $resultId
     */
    protected function storeAnswerExam($respuesta, $question, $resultId) {
        $resultItem = new ResultItem();
        $resultItem->indication = $question;
        $resultItem->answer = $respuesta;
        $resultItem->result = $resultId;
        $resultItem->by = Auth::id();
        $resultItem->save();
    }
}
