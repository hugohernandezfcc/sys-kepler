<?php

namespace App\Http\Controllers;

use App\ApplyExam;
use Auth;
use Illuminate\Http\Request;

class ApplyExamsController extends Controller
{
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
            return Response()->json(array('result' => 'ok'));
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\ApplyExam  $applyExam
     * @return \Illuminate\Http\Response
     */
    public function show(ApplyExam $applyExam)
    {
        //
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
