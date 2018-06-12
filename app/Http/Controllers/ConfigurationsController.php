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
    public function create($viewReturn = null)
    {
        if (Auth::user()->type == "admin") {
            if ($viewReturn !== null) {
                if ($viewReturn !== 'inscriptions') {
                    $viewAux = '/configurations/createinscriptions/' . $viewReturn;
                } else {
                    $viewAux = '/configurations/createinscriptions';
                }
            } else {
                $viewAux = null;
            }
            return view('configurations', [
                    'typeView' => 'form',
                    'viewReturn' => $viewAux
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
    public function createinscriptions($typeUser = null)
    {
        if (Auth::user()->type == "admin") {
            return view('configurations', [
                    'typeView' => 'inscription',
                    'columns' => Column::where('required', '=', false)->get(),
                    'typeUser' => $typeUser
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
    public function store(Request $request, $continue = null)
    {
        $columnName = strtolower(str_replace(' ', '_', $request->columnName));
        $auxColumnName = strtolower($request->columnName);
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
            if ($continue !== null) {
                return Response()->json(array('result' => 'ok', 'column' => $auxColumnName));
            } elseif ($request->viewReturn !== null) {
                return redirect($request->viewReturn);
            }
            return redirect('/profile/inscriptions');
        } else {
            if ($continue !== null) {
                return Response()->json(array('result' => '404', 'column' => $auxColumnName));
            } elseif ($request->viewReturn !== null) {
                return redirect($request->viewReturn);
            }
            return redirect('/profile/inscriptions');
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
            if ($request->viewReturn !== null) {
                return redirect($request->viewReturn);
            } else {
                return redirect('/profile/inscriptions');
            }
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
