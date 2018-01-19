<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
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
        $articles = Article::all();

        return $articles;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $article = new Article();

        $article->name = $request->get('name');
        $article->description = $request->get('description');
        $article->created_by = $request->user()->id;
        $article->module_id = $request->module()->id;

        $article->save();
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
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article) {
        return view('nombre_vista')->with(['article', $article])
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article) {
        $article->name = $request->get('name');
        $article->description = $request->get('description');

        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article) {
        $article->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}