<?php

namespace App\Http\Controllers;

use App\Post;
use App\Conversation;
use App\ItemConversation;
use App\Wall;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idRecord = $request->id_record;
        $table = $request->table;
        $wall = Wall::find($idRecord);

        $post = new Post();
        $post->name = $wall->name;
        $post->body = $request->comentario;
        $post->created_by = Auth::id();
        $post->wall_id = $wall->id;
        if ($post->save()) {
            $conversation_aux = Conversation::where('table', '=', $table)->where('id_record', '=', $idRecord)->get();
            if (count($conversation_aux) > 0) {
                $conversation = (object) array('id' => $conversation_aux[0]->id);
            } else {
                $conversation = new Conversation();
                $datosTabla = DB::table($table)->where('id', '=', $idRecord)->first();
                $conversation->name = $datosTabla->name;
                $conversation->table = $table;
                $conversation->id_record = $idRecord;
                $conversation->save();
            }
            $itemConversation = new ItemConversation();
            $itemConversation->type = $request->type;
            $itemConversation->parent = ($itemConversation->type === 'Question') ? null : $request->parent;
            $itemConversation->name = $post->id;
            $itemConversation->by = Auth::id();
            $itemConversation->conversation = $conversation->id;
            if($itemConversation->save()){
                $post->user_name = Auth::user()->name;
                $post->tiempo = $post->created_at->diffForHumans();
                return response()->json($post);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
