<?php

namespace App\Http\Controllers;

use App\Group;
use App\Conversation;
use App\ItemConversation;
use App\Subject;
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
                'records' => Group::orderBy('created_at', 'desc')
                                ->get()
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
        $group = new Group();
        return view('groups', [
                'typeView' => 'form',
                'record' => $group,
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
                    $group->users()->attach($user, ['name' => $group->name, 'created_by' => Auth::id()]);
                }
            }
            
            return redirect('/groups/show/' . $group->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $groupId
     * @return \Illuminate\Http\Response
     */
    public function show($groupId)
    {
        $comments = [];
        $conversation = Conversation::where('table', '=', 'groups')->where('id_record', '=', $groupId)->orderBy('created_at', 'asc')->get();
        if (count($conversation) > 0) {
            $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

            $comments = $this->obtenerComentarios($questions, $conversation);
        }
        return view('groups', [
                'typeView' => 'view',
                'record' => Group::find($groupId),
                'comments' => $comments
            ]
        );
    }
    
    /**
     * Se obtienen todos los comentarios, según el tipo y manteniendo el parent
     * 
     * @param type $auxs
     * @param type $conversation
     * @return type
     */
    public function obtenerComentarios($auxs, $conversation) {
        $comentarios = [];
        foreach ($auxs as $key => $comment) {
            $comentarios[$key]['Question'] = $comment;
            $comentarios[$key]['Answer'][0] = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent', '=', $comment->id)->orderBy('parent', 'asc')->get();
            if (count($comentarios[$key]['Answer'][0]) > 0) {
                foreach ($comentarios[$key]['Answer'][0] as $key_answer => $answer) {
                    $comentarios[$key]['Answer'][0][$key_answer]['AnswerToAnswer'] = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent', '=', $answer->id)->orderBy('parent', 'asc')->get();
                }
            }
        }
        return $comentarios;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $groupId
     * @return \Illuminate\Http\Response
     */
    public function edit($groupId)
    {
        return view('groups', [
                'typeView' => 'form',
                'record' => Group::find($groupId),
                'to_related' => DB::table('users')->get()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $group = Group::find($request->idRecord);
        $group->name = $request->name;
        $group->description = $request->description;
        $group->touch();
        if ($group->update()) {
            $usersSelected = ($request->users !== null ? explode(',', $request->users) : null);
            if ($group->users !== null) {
                foreach ($group->users as $userGroup) {
                    $encontrado = false;
                    if ($usersSelected !== null) {
                        foreach ($usersSelected as $key => $user) {
                            if ($user == $userGroup->id) {
                                $encontrado = true;
                                unset($usersSelected[$key]);
                                break;
                            }
                        }
                    }
                    if (!$encontrado) {
                        $group->users()->detach($userGroup->id);
                    }
                }
            }
            if ($usersSelected !== null) {
                foreach ($usersSelected as $userGroup) {
                    if ($userGroup !== '') {
                        $group->users()->attach($userGroup, ['name' => $group->name, 'created_by' => Auth::id()]);
                    }
                }
            }
            return redirect('/groups/show/' . $group->id);
        }
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
