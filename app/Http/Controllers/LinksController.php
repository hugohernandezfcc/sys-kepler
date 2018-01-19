<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinksController extends Controller
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
        $links = Link::all();

        return $links;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $link = new Link();

        $link->name = $request->get('name');
        $link->description = $request->get('description');
        $link->created_by = $request->user()->id;
        $link->module_id = $request->module()->id;

        $link->save();
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
     * @param  \App\link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link) {
        return view('nombre_vista')->with(['link', $link])
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link) {
        $link->name = $request->get('name');
        $link->description = $request->get('description');

        $link->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link) {
        $link->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
