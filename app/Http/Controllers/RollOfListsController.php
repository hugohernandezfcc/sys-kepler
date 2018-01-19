<?php

namespace App\Http\Controllers;

use App\RollOfList;
use Illuminate\Http\Request;

class RollOfListsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        $rollOfLists = RollOfList::all();

        return $rollOfLists;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rollOfList = new Exam();

        $rollOfList->name = $request->get('name');
        $rollOfList->created_by = $request->user()->id;
        $rollOfList->subject_id = $request->subject()->id;

        $rollOfList->save();
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
     * @param  \App\RollOfList  $rollOfList
     * @return \Illuminate\Http\Response
     */
    public function show(RollOfList $rollOfList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RollOfList  $rollOfList
     * @return \Illuminate\Http\Response
     */
    public function edit(RollOfList $rollOfList)
    {
        return view('nombre_vista')->with(['rollOfList', $rollOfList])
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RollOfList  $rollOfList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RollOfList $rollOfList)
    {
        $rollOfList->name = $request->get('name');

        $rollOfList->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RollOfList  $rollOfList
     * @return \Illuminate\Http\Response
     */
    public function destroy(RollOfList $rollOfList)
    {
        $rollOfList->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
