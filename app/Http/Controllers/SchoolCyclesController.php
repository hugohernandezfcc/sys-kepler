<?php

namespace App\Http\Controllers;

use App\SchoolCycle;
use Illuminate\Http\Request;

class SchoolCyclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('schoolcycles', [
                'typeView'  => 'list'
                //'records' => SchoolCycle::all()
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
        return view('schoolcycles', [
                'typeView' => 'form'
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolCycle  $schoolCycle
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolCycle $schoolCycle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SchoolCycle  $schoolCycle
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolCycle $schoolCycle)
    {
        return view('nombre_vista')->with(['schoolCycle', $schoolCycle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolCycle  $schoolCycle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolCycle $schoolCycle)
    {
        $schoolCycle->name = $request->get('name');

        $schoolCycle->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolCycle  $schoolCycle
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolCycle $schoolCycle)
    {
        $schoolCycle->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
