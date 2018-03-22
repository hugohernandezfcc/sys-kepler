<?php

namespace App\Http\Controllers;

use App\SchoolCycle;
use App\Conversation;
use App\ItemConversation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SchoolCyclesController extends Controller
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
        return view('schoolcycles', [
                'typeView'  => 'list',
                'records' => SchoolCycle::all()
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
        $schoolCycle = new SchoolCycle();
        return view('schoolcycles', [
                'typeView' => 'form',
                'record' => $schoolCycle
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
        $SchoolCycle = new SchoolCycle();

        $SchoolCycle->name = $request->name;
        $SchoolCycle->start = $request->start;
        $SchoolCycle->end = $request->end;
        $SchoolCycle->description = $request->description;
        $SchoolCycle->created_by = Auth::id();


        if($SchoolCycle->save()){
            return redirect('/cyclescontrol/show/' . $SchoolCycle->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolCycle  $schoolCycleId
     * @return \Illuminate\Http\Response
     */
    public function show($schoolCycleId)
    {
        $comments = [];
        $conversation = Conversation::where('table', '=', 'school_cycles')->where('id_record', '=', $schoolCycleId)->orderBy('created_at', 'asc')->get();
        if (count($conversation) > 0) {
            $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

            $comments = $this->obtenerComentarios($questions, $conversation);
        }

        return view('schoolcycles', [
                'typeView' => 'view',
                'record' => SchoolCycle::find($schoolCycleId),
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
     * @param  \App\SchoolCycle  $schoolCycleId
     * @return \Illuminate\Http\Response
     */
    public function edit($schoolCycleId)
    {
        return view('schoolcycles', [
                'typeView' => 'form',
                'record' => SchoolCycle::find($schoolCycleId)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolCycle  $schoolCycle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $schoolCycle = SchoolCycle::find($request->idRecord);
        $schoolCycle->name = $request->name;
        $schoolCycle->description = $request->description;
        $schoolCycle->start = $request->start;
        $schoolCycle->end = $request->end;
        if ($schoolCycle->update()) {
            return redirect('/cyclescontrol/show/' . $schoolCycle->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolCycle  $schoolCycle
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolCycle $schoolCycle)
    {
        $schoolCycle->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
