<?php

namespace App\Http\Controllers;

use App\Result;
use App\ResultItem;
use App\Task;
use App\Exam;
use Illuminate\Http\Request;

class ResultsController extends Controller
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
     * @param  \Illuminate\App\Test o Task  $type
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $typeEval = explode("-", $type);
        if ($typeEval[0] === 'test') {
            $to_related = Exam::find($typeEval[1]);
            $records = Result::where('id_record', '=', $typeEval[1])->where('type', '=', 'result test')->get()->groupBy('group_id');
            $typeResult = 'test';
        } else if ($typeEval[0] === 'task') {
            $to_related = Task::find($typeEval[1]);
            $records = Result::where('id_record', '=', $typeEval[1])->where('type', '=', 'result task')->get()->groupBy('group_id');
            $typeResult = 'task';
        }
//        dd($to_related);
//        dd($records);
        return view('results', [
                'typeView'  => 'list',
                'typeResult'  => $typeResult,
                'records' => $records,
                'to_related' => $to_related
            ]
        );
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
        //
    }
    
    /**
     * Display the specified resource.
     *
     * @param  mixed  $typeGroupIdExamId
     * @return \Illuminate\Http\Response
     */
    public function show($typeGroupIdExamId)
    {
        $evaluation = explode("-", $typeGroupIdExamId);
        if ($evaluation[0] === 'test') {
            $to_related = Exam::find($evaluation[1]);
            $results = Result::where('id_record', '=', $evaluation[1])->where('type', '=', 'result test')->where('group_id', '=', $evaluation[2])->get();
            $typeResult = 'test';
        } else if ($evaluation[0] === 'task') {
            $to_related = Task::find($evaluation[1]);
            $results = Result::where('id_record', '=', $evaluation[1])->where('type', '=', 'result task')->where('group_id', '=', $evaluation[2])->get();
            $typeResult = 'task';
        }
        $records = [];
        foreach ($results as $result) {
            $records[] = ResultItem::where('result', '=', $result->id)->get()->groupBy('by');
        }
        return view('results', [
                'typeView'  => 'view',
                'typeResult'  => $typeResult,
                'records' => $records,
                'to_related' => $to_related
            ]
        );
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }
}
