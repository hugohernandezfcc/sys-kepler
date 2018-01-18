<?php

namespace App\Http\Controllers;

use App\SchoolCycle;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SchoolCyclesController extends Controller
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
        $SchoolCycle = new SchoolCycle();

        $SchoolCycle->name = $request->name;
        $SchoolCycle->start = $request->start;
        $SchoolCycle->end = $request->end;
        $SchoolCycle->description = $request->description;
        $SchoolCycle->created_by = Auth::id();


        if($SchoolCycle->save()){
            return redirect('/cyclescontrol/show/' . $SchoolCycle->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolCycle  $schoolCycle
     * @return \Illuminate\Http\Response
     */
    public function show($schoolCycleId)
    {


        return view('schoolcycles', [
                'typeView' => 'view',
                'record' => SchoolCycle::find($schoolCycleId)
            ]
        ); 
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
