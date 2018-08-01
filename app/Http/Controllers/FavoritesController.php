<?php

namespace App\Http\Controllers;

use Auth;
use App\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
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
        $fav = $this->obtenerFavorites();
        return Response()->json(array('favorites' => $fav));
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
        $favorite = new Favorite();
        $favorite->name = $request->name;
        $favorite->domain = explode('/', $request->link)[3];
        $favorite->link = $request->link;
        $favorite->by = Auth::id();
        $favorite->type = explode('/', $request->link)[3];
        if ($favorite->save()) {
            $fav = $this->obtenerFavorites();
            return Response()->json(array('favorites' => $fav));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
    * Retorna todos los favoritos del usuario, incluyendo el time con Carbon 
    *
    * @return \App\Favorite  $favorites
    */
    protected function obtenerFavorites() {
        $fav = Favorite::where('by', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get()->groupBy('type');
        foreach ($fav as &$favType) {
            foreach ($favType as &$item) {
                $item->time = $item->created_at->diffForHumans();
            }
        }
        return $fav;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Favorite::where('link', '=', $request->link)->where('by', '=', Auth::user()->id)->delete();
        
        $fav = $this->obtenerFavorites();
        return Response()->json(array('favorites' => $fav));
    }
}
