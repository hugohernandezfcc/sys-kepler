<?php

namespace App\Http\Controllers;

use App\Wall;
use Illuminate\Http\Request;

class WallsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read() {
        $walls = Wall::all();

        return $walls;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $wall = new Wall();

        $wall->name = $request->get('name');
        $wall->description = $request->get('description');
        $wall->created_by = $request->user()->id;
        $wall->module_id = $request->module()->id;

        $wall->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function show(Wall $wall) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function edit(Wall $wall) {
        return view('nombre_vista')->with(['wall', $wall])
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wall $wall) {
        $wall->name = $request->get('name');
        $wall->description = $request->get('description');

        $wall->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wall $wall) {
        $wall->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
