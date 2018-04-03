<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Conversation;
use App\ItemConversation;
use App\Module;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumsController extends Controller
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
        return view('forums', [
                'typeView'  => 'list',
                'records' => Forum::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\module  $moduleId
     * @return \Illuminate\Http\Response
     */
    public function create($moduleId = null) {
        if ($moduleId !== null) {
            $module = Module::find($moduleId);
        } else {
            $module = new Module();
        }
        $forum = new Forum();
        return view('forums', [
                'typeView' => 'form',
                'record' => $forum,
                'to_related' => DB::table('modules')->get(),
                'module' => $module
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
        $forum = new Forum();
        $forum->name = $request->name;
        $forum->module_id = $request->module_id;
        $forum->description = $request->description;
        $forum->created_by = Auth::id();
        if($forum->save()){
            return redirect('/forums/show/' . $forum->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\forum  $forumId
     * @return \Illuminate\Http\Response
     */
    public function show($forumId) {
        $comments = [];
        $conversation = Conversation::where('table', '=', 'forums')->where('id_record', '=', $forumId)->orderBy('created_at', 'asc')->get();
        if (count($conversation) > 0) {
            $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

            $comments = $this->obtenerComentarios($questions, $conversation);
        }

        return view('forums', [
                'typeView' => 'view',
                'record' => Forum::find($forumId),
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
     * @param  \App\forum  $forumId
     * @return \Illuminate\Http\Response
     */
    public function edit($forumId) {
        return view('forums', [
                'typeView' => 'form',
                'to_related' => DB::table('modules')->get(),
                'record' => Forum::find($forumId),
                'module' => new Module()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $forum = Forum::find($request->idRecord);
        $forum->name = $request->name;
        $forum->module_id = $request->module_id;
        $forum->description = $request->description;
        if ($forum->update()) {
            return redirect('/forums/show/' . $forum->id);
        }
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
