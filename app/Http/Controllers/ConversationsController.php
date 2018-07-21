<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\ItemConversation;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class ConversationsController extends Controller {

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $id_record = $request->id_record;
        $table = $request->table;
        $conversation_aux = Conversation::where('table', '=', $table)->where('id_record', '=', $id_record)->get();
        if (count($conversation_aux) > 0) {
            $conversation = (object) array('id' => $conversation_aux[0]->id);
        } else {
            $conversation = new Conversation();
            $datosTabla = DB::table($table)->where('id', '=', $id_record)->first();
            $conversation->name = $datosTabla->name;
            $conversation->table = $table;
            $conversation->id_record = $id_record;
            $conversation->save();
        }
        $itemConversation = new ItemConversation();
        $itemConversation->type = $request->type;
        $itemConversation->parent = ($itemConversation->type === 'Question') ? null : $request->parent;
        $itemConversation->name = $request->comentario;
        $itemConversation->by = Auth::id();
        $itemConversation->conversation = $conversation->id;
        if($itemConversation->save()){
            $itemConversation->user_name = Auth::user()->name;
            $itemConversation->user_id = Auth::user()->id;
            $itemConversation->tiempo = $itemConversation->created_at->diffForHumans();
            return response()->json($itemConversation);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation) {
        //
    }

}
