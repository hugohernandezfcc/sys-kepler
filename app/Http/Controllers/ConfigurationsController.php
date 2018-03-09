<?php

namespace App\Http\Controllers;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$camposUsers = Schema::getColumnListing('users');
        $a = in_array(strtolower('Email'), $camposUsers);
        var_dump($a);
        if(Schema::hasColumn('users', 'email')) { //check whether users table has email column
            var_dump('encontrado email');
         //your logic
        }*/
        $columnName = strtolower($request->columnName);
        if (!Schema::hasColumn('users', $columnName)) {
            if ($request->type === 'integer') {
                DB::statement('ALTER TABLE public.users ADD COLUMN ' . $columnName . ' integer;');
            } else if ($request->type === 'string') {
                DB::statement('ALTER TABLE public.users ADD COLUMN ' . $columnName . ' character varying;');
            } else {
                DB::statement('ALTER TABLE public.users ADD COLUMN ' . $columnName . ' timestamp(0) without time zone;');
            }
            return redirect('/profile');
        } else {
            return redirect('/profile');
        }
    }
}
