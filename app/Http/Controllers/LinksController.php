<?php

namespace App\Http\Controllers;

use App\Link;
use App\Conversation;
use App\ItemConversation;
use App\Module;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinksController extends Controller
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
        return view('links', [
                'typeView'  => 'list',
                'records' => Link::all()
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
        $link = new Link();
        return view('links', [
                'typeView' => 'form',
                'record' => $link,
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
        $link = new Link();
        $link->name = $request->name;
        $link->module_id = $request->module_id;
        $link->description = $request->description;
        $link->link = $request->link;
        $link->created_by = Auth::id();
        if($link->save()){
            return redirect('/links');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\link  $linkId
     * @return \Illuminate\Http\Response
     */
    public function show($linkId) {
        $comments = [];
        $conversation = Conversation::where('table', '=', 'links')->where('id_record', '=', $linkId)->orderBy('created_at', 'asc')->get();
        if (count($conversation) > 0) {
            $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

            $comments = $this->obtenerComentarios($questions, $conversation);
        }

        return view('links', [
                'typeView' => 'view',
                'record' => Link::find($linkId),
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
     * @param  \App\link  $linkId
     * @return \Illuminate\Http\Response
     */
    public function edit($linkId) {
        $module = new Module();
        return view('links', [
                'typeView' => 'form',
                'to_related' => DB::table('modules')->get(),
                'record' => Link::find($linkId),
                'module' => $module
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $link = Link::find($request->idRecord);
        $link->name = $request->name;
        $link->module_id = $request->module_id;
        $link->description = $request->description;
        $link->link = $request->link;
        if ($link->update()) {
            return redirect('/links/show/' . $link->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link) {
        $link->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
