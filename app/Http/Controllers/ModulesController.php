<?php

namespace App\Http\Controllers;

use App\Module;
use App\Conversation;
use App\ItemConversation;
use App\Subject;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulesController extends Controller
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
        return view('modules', [
                'typeView'  => 'list',
                'records' => Module::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\subject  $subjectId
     * @return \Illuminate\Http\Response
     */
    public function create($subjectId = null) {
        if ($subjectId !== null) {
            $subject = Subject::find($subjectId);
        } else {
            $subject = new Subject();
        }
        $module = new Module();
        return view('modules', [
                'typeView' => 'form',
                'record' => $module,
                'to_related' => DB::table('subjects')->get(),
                'subject' => $subject
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
        $module = new Module();
        $module->name = $request->name;
        $module->subject_id = $request->subject_id;
        $module->created_by = Auth::id();
        if($module->save()){
            return redirect('/modules/show/' . $module->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\module  $moduleId
     * @return \Illuminate\Http\Response
     */
    public function show($moduleId) {
        $comments = [];
        $conversation = Conversation::where('table', '=', 'modules')->where('id_record', '=', $moduleId)->orderBy('created_at', 'asc')->get();
        if (count($conversation) > 0) {
            $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

            $comments = $this->obtenerComentarios($questions, $conversation);
        }

        return view('modules', [
                'typeView' => 'view',
                'record' => Module::find($moduleId),
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
     * @param  \App\module  $moduleId
     * @return \Illuminate\Http\Response
     */
    public function edit($moduleId)
    {
        return view('modules', [
                'typeView' => 'form',
                'to_related' => DB::table('subjects')->get(),
                'record' => Module::find($moduleId),
                'subject' => new Subject()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $module = Module::find($request->idRecord);
        $module->name = $request->name;
        $module->subject_id = $request->subject_id;
        if ($module->update()) {
            return redirect('/modules/show/' . $module->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}