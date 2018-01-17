<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessToController extends Controller
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
        $accessTo = AccessTo::all();

        return $accessTo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accessTo = new AccessTo();

        $accessTo->name = $request->get('name');
        $accessTo->created_by = $request->user()->id;
        $accessTo->user_id = $request->users()->id;
        $accessTo->group_id = $request->groups()->id;

        $accessTo->save();
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
     * @param  \App\AccessTo  $accessTo
     * @return \Illuminate\Http\Response
     */
    public function show(AccessTo $accessTo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccessTo  $accessTo
     * @return \Illuminate\Http\Response
     */
    public function edit(AccessTo $accessTo)
    {
        return view('nombre_vista')->with(['accessTo', $accessTo])
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccessTo  $accessTo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccessTo $accessTo)
    {
        $accessTo->name = $request->get('name');

        $accessTo->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccessTo  $accessTo
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccessTo $accessTo)
    {
        $accessTo->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
