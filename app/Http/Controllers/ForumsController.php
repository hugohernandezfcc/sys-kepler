<?php

namespace App\Http\Controllers;

use App\Forum;
use Illuminate\Http\Request;

class ForumsController extends Controller
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
        $forums = Forum::all();

        return $forums;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $forum = new Forum();

        $forum->name = $request->get('name');
        $forum->description = $request->get('description');
        $forum->created_by = $request->user()->id;
        $forum->module_id = $request->module()->id;

        $forum->save();
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
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function edit(Forum $forum) {
        return view('nombre_vista')->with(['forum', $forum])
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum) {
        $forum->name = $request->get('name');
        $forum->description = $request->get('description');

        $forum->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum) {
        $forum->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
