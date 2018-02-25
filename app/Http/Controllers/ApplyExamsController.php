<?php

namespace App\Http\Controllers;

use App\ApplyExam;
use App\Exam;
use App\ItemsExam;
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
        $examId = $request->examId;
        $questionExams = ItemsExam::where('exam', '=', $examId)->where('parent', '=', null)->get();
        foreach ($questionExams as $question) {
            $questionOpenTxt = 'Open-question'.$question->id;
            $questionSingleTxt = 'Single-question'.$question->id;
            if ($request->$questionOpenTxt !== null) {
                $this->storeAnswerExam($request->$questionOpenTxt, 'Open', $question->id, $examId);
            } else if ($request->$questionSingleTxt !== null) {
                $answer = ItemsExam::where('id', '=', $request->$questionSingleTxt)->first();
                $this->storeAnswerExam($answer->name, 'Single option', $question->id, $examId);
            } else {
                foreach ($question->children()->where('type', '=', 'Question')->get() as $detalle) {
                    $questionMultipleTxt = 'Multiple-question'.$question->id.'-option'.$detalle->id;
                    if ($request->$questionMultipleTxt !== null) {
                        $this->storeAnswerExam($detalle->name, 'Multiple option', $question->id, $examId);
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
     * @param string $subtype
     * @param integer $questionId
     * @param integer $examId
     */
    protected function storeAnswerExam($respuesta, $subtype, $questionId, $examId) {
        $itemsExamA = new ItemsExam();
        $itemsExamA->name = $respuesta;
        $itemsExamA->type = 'Answer';
        $itemsExamA->subtype = $subtype;
        $itemsExamA->parent = $questionId;
        $itemsExamA->by = Auth::id();
        $itemsExamA->exam = $examId;
        $itemsExamA->save();
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
