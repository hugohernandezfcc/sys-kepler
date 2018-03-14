<?php

namespace App\Http\Controllers;

use App\Column;
use App\Inscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Auth;

class ConfigurationsController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->type == "admin") {
            return view('configurations', [
                    'typeView' => 'form'
                ]
            );
        } else {
            return redirect('/404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createinscriptions()
    {
        if (Auth::user()->type == "admin") {
            return view('configurations', [
                    'typeView' => 'inscription',
                    'columns' => Column::where('required', '=', false)->get()
                ]
            );
        } else {
            return redirect('/home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $columnName = strtolower($request->columnName);
        if (!Schema::hasColumn('users', $columnName)) {
            $newColumn = new Column();
            $newColumn->name = $columnName;
            $newColumn->type = $request->type;
            $newColumn->label = $request->columnLabel;
            $newColumn->required = $request->columnRequired;
            $newColumn->created_by = Auth::id();
            if($newColumn->save()) {
                if ($newColumn->type === 'integer') {
                    DB::statement('ALTER TABLE public.users ADD COLUMN ' . $columnName . ' integer;');
                } else if ($newColumn->type === 'string') {
                    DB::statement('ALTER TABLE public.users ADD COLUMN ' . $columnName . ' character varying;');
                } else {
                    DB::statement('ALTER TABLE public.users ADD COLUMN ' . $columnName . ' timestamp(0) without time zone;');
                }
            }
            return redirect('/profile');
        } else {
            return redirect('/profile');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeinscriptions(Request $request)
    {
        $columnsName = $request->columnsName;
        $listColumn = '';
        foreach ($columnsName as $value) {
            if ($value === end($columnsName)) {
                $listColumn = $listColumn . $value;
                break;
            }
            $listColumn = $listColumn . $value . '-';
        }
        $ranString = openssl_random_pseudo_bytes(6);
        $name = bin2hex($ranString);
        $inscription = new Inscription();
        $inscription->name = time().$name;
        $inscription->description = $request->description;
        $inscription->columns_name = $listColumn;
        $inscription->created_by = Auth::id();
        $inscription->type_user = $request->type;
        if ($inscription->save()) {
            return redirect('/profile/inscriptions');
        } else {
            return redirect('/404');
        }
    }
    
    /**
     * Se obtienen los todos los campos de la tabla Users y luego se trabaja a partir de los nuevos campos
     * que estarian despues de 'avatar'; sino hay nuevos campos se retorna un array vacio.
     * 
     * @return array
     */
    protected function camposUsers() {
        $auxCamposUsers = Column::where('required', '=', false)->get();
        $camposUsers=[];
        foreach ($auxCamposUsers as $key => $column) {
            $camposUsers[$key] = ['tipo' => $column->type, 'valor' => $column->name];
        }
        return $camposUsers;
    }
}
