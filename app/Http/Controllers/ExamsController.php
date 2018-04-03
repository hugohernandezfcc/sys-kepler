<?php

namespace App\Http\Controllers;

use App\Exam;
use App\ItemsExam;
use App\Subject;
use App\Group;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamsController extends Controller
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
        return view('test', [
                'typeView'  => 'list',
                'records' => Exam::all()
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
        $exams = Exam::all();

        return $exams;
    }

    /**
     * Show the form for creating a new resource.
     * @param  \App\module  $subjectId
     * @return \Illuminate\Http\Response
     */
    public function create($subjectId = null) {
        if ($subjectId !== null) {
            $subject = Subject::find($subjectId);
            $to_related = DB::table('subjects')->get();
        } else {
            $subject = new Subject();
            $to_related = Subject::all()->groupBy('area_id');
        }
        return view('test', [
                'typeView' => 'form',
                'to_related' => $to_related,
                'subject' => $subject
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
        $exam = new Exam();
        $exam->name = $request->name;
        $exam->description = $request->description;
        $exam->subject_id = $request->subject_id;
        $subject = Subject::find($request->subject_id);
        $exam->area_id = $subject->area_id;
        $exam->created_by = Auth::id();
        if ($exam->save()) {
            $this->storeItemsExam($request, $exam->id);
        }
        return redirect('/test/show/' . $exam->id);
    }
    
    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Exam $examId
     */
    protected function storeItemsExam($request, $examId) {
        $totalQuestion = $request->totalQuestion;
        for ($i = 1; $i <= $totalQuestion; $i++) {
            $itemsExamQ = new ItemsExam();
            $questionTxt = "question$i";
            $itemsExamQ->name = $request->$questionTxt;
            $itemsExamQ->type = 'Question';
            $itemsExamQ->parent = null;
            $itemsExamQ->by = Auth::id();
            $itemsExamQ->exam = $examId;
            if ($itemsExamQ->save()) {
                $subtypeTxt = "question$i-subtype$i";
                $subtype = str_replace('-', ' ', $request->$subtypeTxt);
                if ($subtype === 'Question') { 
                    $itemsExamA = new ItemsExam();
                    $itemsExamA->name = '';
                    $itemsExamA->type = 'Question';
                    $itemsExamA->subtype = 'Open';
                    $itemsExamA->parent = $itemsExamQ->id;
                    $itemsExamA->by = Auth::id();
                    $itemsExamA->exam = $examId;
                    $itemsExamA->save();
                } else {//Single-option y Multiple-option
                    $j = 1;
                    $optionsTxt = "question$i-option$j";
                    while ($request->$optionsTxt !== null) {
                        $itemsExamA = new ItemsExam();
                        $itemsExamA->name = $request->$optionsTxt;
                        $itemsExamA->type = 'Question';
                        $itemsExamA->subtype = $subtype;
                        $itemsExamA->parent = $itemsExamQ->id;
                        $itemsExamA->by = Auth::id();
                        $itemsExamA->exam = $examId;
                        $itemsExamA->save();
                        $j++;
                        $optionsTxt = "question$i-option$j";
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $examId
     * @return \Illuminate\Http\Response
     */
    public function show($examId)
    {
        return view('test', [
                'typeView' => 'view',
                'record' => Exam::find($examId),
                'items_exam' => ItemsExam::where('exam', '=', $examId)->where('parent', '=', null)->get(),
                'to_related' => Group::all()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        return view('nombre_vista')->with(['exam', $exam]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $exam->name = $request->get('name');

        $exam->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
