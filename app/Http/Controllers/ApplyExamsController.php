<?php

namespace App\Http\Controllers;

use App\ApplyExam;
use App\Exam;
use App\ItemsExam;
use App\Result;
use App\ResultItem;
use Auth;
use Illuminate\Http\Request;

class ApplyExamsController extends Controller
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
        $applyExam = new ApplyExam();
        $applyExam->name = time().$name;
        $applyExam->exam_id = $request->examId;
        $applyExam->group_id = $request->groupId;
        $applyExam->by = Auth::id();
        if ($applyExam->save()) {
            //$this->enviarMail($applyExam);
            return Response()->json(array('result' => 'ok', 'codeExam' => $applyExam->name));
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\ApplyExam  $applyExamName
     * @return \Illuminate\Http\Response
     */
    public function takeexam($applyExamName)
    {
        $takeExam = ApplyExam::where('name', '=', $applyExamName)->first();
        if ($takeExam !== null) {
            return view('takeexam', [
                'typeView' => 'takeexam',
                'record' => Exam::find($takeExam->exam_id),
                'items_exam' => ItemsExam::where('exam', '=', $takeExam->exam_id)->where('parent', '=', null)->get(),
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
        $exam = Exam::where('id', '=', $request->examId)->first();
        $questionExams = ItemsExam::where('exam', '=', $exam->id)->where('parent', '=', null)->get();
        $result = new Result();
        $result->id_record = $exam->id;
        $result->name_record = $exam->name;
        $result->type = 'result test';
        $result->by = Auth::id();
        if ($result->save()) {
            foreach ($questionExams as $question) {
                $questionOpenTxt = 'Open-question'.$question->id;
                $questionSingleTxt = 'Single-question'.$question->id;
                if ($request->$questionOpenTxt !== null) {
                    $this->storeAnswerExam($request->$questionOpenTxt, $question->name, $result->id);
                } else if ($request->$questionSingleTxt !== null) {
                    $answer = ItemsExam::where('id', '=', $request->$questionSingleTxt)->first();
                    $this->storeAnswerExam($answer->name, $question->name, $result->id);
                } else {
                    foreach ($question->children()->where('type', '=', 'Question')->get() as $detalle) {
                        $questionMultipleTxt = 'Multiple-question'.$question->id.'-option'.$detalle->id;
                        if ($request->$questionMultipleTxt !== null) {
                            $this->storeAnswerExam($detalle->name, $question->name, $result->id);
                        }
                    }
                }
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
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApplyExam  $applyExam
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplyExam $applyExam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApplyExam  $applyExam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplyExam $applyExam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplyExam  $applyExam
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplyExam $applyExam)
    {
        //
    }
}
