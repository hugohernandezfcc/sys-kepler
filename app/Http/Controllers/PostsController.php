<?php

namespace App\Http\Controllers;

use App\Post;
use App\Conversation;
use App\ItemConversation;
use App\Wall;
use App\Like;
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
        $this->middleware('auth')->except('storeGuest');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        return $this->storePost($request, $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGuest(Request $request)
    {
        $user = (object) $request->user;
        return $this->storePost($request, $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePost($request, $user)
    {
        $idRecord = $request->id_record;
        $table = $request->table;
        $wall = Wall::find($idRecord);

        $post = new Post();
        $post->name = $wall->name;
        $post->body = $request->comentario;
        $post->created_by = $user->id;
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
            $itemConversation->by = $user->id;
            $itemConversation->conversation = $conversation->id;
            if($itemConversation->save()){
                $post->user_name = $user->name;
                $post->user_id = $user->id;
                $post->item = $itemConversation->id;
                $post->tiempo = $post->created_at->diffForHumans();
                return response()->json($post);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeLike(Request $request)
    {
        $texto = '';
        $post = Post::find($request->postId);
        $likeAux = $post->likes->where('created_by', '=', Auth::id())->first();
        if ($likeAux !== null) {
            //dd($likeAux);
            Like::destroy($likeAux->id);
            if ($post->likes->count() - 1 === 0) {
                $texto = ' Me gusta';
            } else {
                $texto = ' ' . $post->likes->count() - 1 . ' Me gusta';
            }
        } else {
            $like = new Like();

            $like->name = $post->name;
            $like->body = $post->body;
            $like->post_id = $post->id;
            $like->created_by = Auth::id();
            if ($like->save()) {
                $texto = ' ' . $post->likes->count() + 1 . ' Ya no me gusta';
            }
        }
        return response()->json($texto);
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
