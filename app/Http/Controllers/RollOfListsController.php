<?php

namespace App\Http\Controllers;

use App\RollOfList;
use App\Group;
use Auth;
use Illuminate\Http\Request;

class RollOfListsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('list', [
                'typeView'  => 'list',
                'records' => Group::all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $group = Group::find($request->idRecord);
        $asistentes = 0;
        $missing = [];
        foreach ($group->users as $user) {
            $userId = $user->id;
            if ($request->$userId === 'on') {
                $asistentes++;
            } else {
                $missing[] = array('id' => $userId, 'name' => $user->name);
            }
        }
        $porcentaje = ($group->users->count() != 0 ? $asistentes*100/$group->users->count() : 0);
        $list = new RollOfList();
        $list->name = $group->name;
        $list->missing = json_encode($missing);
        $list->percentage = $porcentaje;
        $list->created_by = Auth::id();
        $list->group_id = $group->id;
        if($list->save()){
            return redirect('/list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $groupId
     * @return \Illuminate\Http\Response
     */
    public function show($groupId) {
        return view('list', [
                'typeView' => 'view',
                'record' => Group::find($groupId)
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RollOfList  $rollOfList
     * @return \Illuminate\Http\Response
     */
    public function edit(RollOfList $rollOfList) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RollOfList  $rollOfList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RollOfList $rollOfList) {
        $rollOfList->name = $request->get('name');

        $rollOfList->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RollOfList  $rollOfList
     * @return \Illuminate\Http\Response
     */
    public function destroy(RollOfList $rollOfList) {
        $rollOfList->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
