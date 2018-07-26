<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\ItemConversation;
use App\Like;
use App\Post;
use Illuminate\Http\Request;

class ItemsConversationsController extends Controller {

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ItemConversation  $itemConversation
     * @return \Illuminate\Http\Response
     */
    public function show(ItemConversation $itemConversation) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ItemConversation  $itemConversation
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemConversation $itemConversation) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ItemConversation  $itemConversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemConversation $itemConversation) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemConversation  $itemConversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $result = $time = '';
        $itemConversation = ItemConversation::find($request->itemConversationId);
        if ($request->type === 'Question') {
            $children = ItemConversation::where('parent', '=', $itemConversation->id)->get();
            if ($children->count() === 0) {
                $aux = $itemConversation->conversation;
                ItemConversation::destroy($itemConversation->id);
                $conversations = ItemConversation::where('conversation', '=', $aux);
                if ($conversations->count() === 0) {
                    $conversation = Conversation::destroy($aux);
                }
                $result = 'delete';
            } else {
                $itemConversation->name = "este comentario se ha eliminado";
                if ($itemConversation->update()) {
                    $result = 'update';
                    $time = $itemConversation->updated_at->diffForHumans();
                }
            }
        } elseif ($request->type === 'AnswerForum') {
            $children = ItemConversation::where('parent', '=', $itemConversation->id)->get();
            if ($children->count() === 0) {
                ItemConversation::destroy($itemConversation->id);
                $result = 'delete';
            } else {
                $itemConversation->name = "este comentario se ha eliminado";
                if ($itemConversation->update()) {
                    $result = 'update';
                    $time = $itemConversation->updated_at->diffForHumans();
                }
            }
        } elseif ($request->type === 'QuestionWall') {
            $children = ItemConversation::where('parent', '=', $itemConversation->id)->get();
            if ($children->count() === 0) {
                $post = Post::where('id', '=', $itemConversation->name)->first();
                ItemConversation::destroy($itemConversation->id);
                $likes = $post->likes()->get();
                foreach ($likes as $like) {
                    Like::destroy($like->id);
                }
                Post::destroy($post->id);
                $result = 'delete';
            } else {
                $post = Post::where('id', '=', $itemConversation->name)->first();
                $post->body = "este comentario se ha eliminado";
                $itemConversation->name = "este comentario se ha eliminado";
                if ($post->update()) {
                    $result = 'update';
                    $time = $post->updated_at->diffForHumans();
                }
            }
        } else {

        }

        return Response()->json(array('result' => $result, 'itemConversation' => $itemConversation, 'time' => $time));
    }

}
