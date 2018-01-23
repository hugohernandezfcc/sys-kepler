<?php

namespace App\Http\Controllers;

use App\Group;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class GroupsController extends Controller
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
        return view('groups', [
                'typeView'  => 'list',
                'records' => Group::all()
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        $groups = Group::all();

        return $groups;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups', [
                'typeView' => 'form',
                'to_related' => DB::table('users')->get()
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
        $group = new Group();

        $group->name = $request->name;
        $group->description = $request->description;
        $group->created_by = Auth::id();
        if ($group->save()) {

            if ($request->users != null) {
                $users = explode(',', $request->users);
                foreach ($users as $user) {
                    $group->users()->attach($user->id, ['name' => $group->name, 'created_by' => Auth::id()]);
                }
            }
            
            return redirect('/groups/show/' . $group->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($groupId)
    {
        return view('groups', [
                'typeView' => 'view',
                'record' => Group::find($groupId)
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('nombre_vista')->with(['group', $group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $group->name = $request->get('name');

        $group->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
