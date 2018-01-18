<?php

namespace App\Http\Controllers;

use App\Area;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AreasController extends Controller
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
        return view('area', [
                'typeView'  => 'list',
                'records' => Area::all()
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
        return view('area', [
                'typeView' => 'form',
                'to_related' => DB::table('school_cycles')->get()
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
        $Area = new Area();

        $Area->name = $request->name;
        $Area->school_cycle_id = $request->school_cycle_id;
        $Area->description = $request->description;
        $Area->created_by = Auth::id();


        if($Area->save()){
            return redirect('/areas/show/' . $Area->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show($areaId)
    {
        return view('area', [
                'typeView' => 'view',
                'record' => Area::find($areaId)
            ]
        ); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //Se recibe el id, que es una instanacia de la clase por lo que
        //a través del modelo tenemos acceso a los datos de allí se retorna
        //el objeto completo.
        return view('nombre_vista')->with(['area', $area]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        $area->name = $request->get('name');

        $area->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
