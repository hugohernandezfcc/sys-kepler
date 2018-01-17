<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplyToController extends Controller
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
        $applyTo = ApplyTo::all();

        return $applyTo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $applyTo = new ApplyTo();

        $applyTo->name $request->get('name');
        $applyTo->created_by = $request->user()->id;
        $accessTo->user_id = $request->users()->id;
        $accessTo->subject_id = $request->subjects()->id;

        $applyTo->save();
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
     * @param  \App\ApplyTo  $applyTo
     * @return \Illuminate\Http\Response
     */
    public function show(ApplyTo $applyTo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApplyTo  $applyTo
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplyTo $applyTo)
    {
        return view('nombre_vista')->with(['applyTo', $applyTo])
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApplyTo  $applyTo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplyTo $applyTo)
    {
        $applyTo->name = $request->get('name');

        $applyTo->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplyTo  $applyTo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplyTo $applyTo)
    {
        $applyTo->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
