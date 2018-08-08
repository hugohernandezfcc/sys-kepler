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
        $this->middleware('auth')->except('destroyGuest');
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
        return $this->destroyConversation($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemConversation  $itemConversation
     * @return \Illuminate\Http\Response
     */
    public function destroyGuest(Request $request) {
        return $this->destroyConversation($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemConversation  $itemConversation
     * @return \Illuminate\Http\Response
     */
    public function destroyConversation($request) {
        $result = $time = '';
        $itemConversation = ItemConversation::find($request->itemConversationId);
        if ($request->type === 'Question') {
            if ($itemConversation->children()->count() === 0) {
                $aux = $itemConversation->conversation;
                ItemConversation::destroy($itemConversation->id);
                $conversations = ItemConversation::where('conversation', '=', $aux);
                if ($conversations->count() === 0) {
                    $conversation = Conversation::destroy($aux);
                }
                $result = 'delete';
            } else {
                $contDelete = 0;
                foreach ($itemConversation->children as $item) {
                    if ($item->name === "Este comentario se ha eliminado") {
                        ++$contDelete;
                    }
                }
                if (($contDelete/$itemConversation->children()->count()) <= 0.5) {
                    $itemConversation->name = "Este comentario se ha eliminado";
                    if ($itemConversation->update()) {
                        $result = 'update';
                        $time = $itemConversation->updated_at->diffForHumans();
                    }
                } else {
                    foreach ($itemConversation->children as $item) {
                        foreach ($item->children as $itemAnswer) {
                            $itemAnswer->delete();
                        }
                        $item->delete();
                    }
                    $aux = $itemConversation->conversation;
                    ItemConversation::destroy($itemConversation->id);
                    $conversations = ItemConversation::where('conversation', '=', $aux);
                    if ($conversations->count() === 0) {
                        $conversation = Conversation::destroy($aux);
                    }
                    $result = 'delete';
                }
            }
        } elseif ($request->type === 'AnswerForum') {
            if ($itemConversation->children()->count() === 0) {
                ItemConversation::destroy($itemConversation->id);
                $result = 'delete';
            } else {
                $itemConversation->name = "Este comentario se ha eliminado";
                if ($itemConversation->update()) {
                    $result = 'update';
                    $time = $itemConversation->updated_at->diffForHumans();
                }
            }
        } elseif ($request->type === 'QuestionWall') {
            if ($itemConversation->children()->count() === 0) {
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
                $post->body = "Esta publicación se ha eliminado";
                $itemConversation->name = "Esta publicación se ha eliminado"; #solo para usar en la vista, no se almacena
                if ($post->update()) {
                    $result = 'update';
                    $time = $post->updated_at->diffForHumans();
                }
            }
        } elseif ($request->type === 'AnswerWall') {
            if ($itemConversation->children()->count() === 0) {
                ItemConversation::destroy($itemConversation->id);
                $result = 'delete';
            } elseif (Post::where('id', '=', $itemConversation->oneparent->name)->first()->body === "Esta publicación se ha eliminado") {
                $contDelete = 1;
                $parent = $itemConversation->oneparent;
                foreach ($parent->children->where('id', '!=', $itemConversation->id) as $item) {
                    if ($item->name === "Este comentario se ha eliminado") {
                        ++$contDelete;
                    }
                }
                if (($contDelete/$parent->children->count()) <= 0.5) {
                    $itemConversation->name = "Este comentario se ha eliminado";
                    if ($itemConversation->update()) {
                        $result = 'update';
                        $time = $itemConversation->updated_at->diffForHumans();
                    }
                } else {
                    $post = Post::where('id', '=', $itemConversation->oneparent->name)->first();
                    foreach ($parent->children as $item) {
                        foreach ($item->children as $itemAnswer) {
                            $itemAnswer->delete();
                        }
                        $item->delete();
                    }
                    ItemConversation::destroy($itemConversation->id);
                    $likes = $post->likes()->get();
                    foreach ($likes as $like) {
                        Like::destroy($like->id);
                    }
                    Post::destroy($post->id);
                    $itemConversation->id = $itemConversation->parent; #para eliminar de la vista la publicacion completa
                    $result = 'delete';
                }
            } else {
                $itemConversation->name = "Este comentario se ha eliminado";
                if ($itemConversation->update()) {
                    $result = 'update';
                    $time = $itemConversation->updated_at->diffForHumans();
                }
            }
        } elseif ($request->type === 'Answer') {
            if ($itemConversation->children()->count() === 0) {
                ItemConversation::destroy($itemConversation->id);
                $result = 'delete';
            } elseif ($itemConversation->oneparent->name === "Este comentario se ha eliminado") {
                $contDelete = 1;
                $parent = $itemConversation->oneparent;
                foreach ($parent->children->where('id', '!=', $itemConversation->id) as $item) {
                    if ($item->name === "Este comentario se ha eliminado") {
                        ++$contDelete;
                    }
                }
                if (($contDelete/$parent->children->count()) <= 0.5) {
                    $itemConversation->name = "Este comentario se ha eliminado";
                    if ($itemConversation->update()) {
                        $result = 'update';
                        $time = $itemConversation->updated_at->diffForHumans();
                    }
                } else {
                    foreach ($parent->children as $item) {
                        foreach ($item->children as $itemAnswer) {
                            $itemAnswer->delete();
                        }
                        $item->delete();
                    }
                    $itemConversation = $parent;
                    $aux = $parent->conversation;
                    ItemConversation::destroy($parent->id);
                    $conversations = ItemConversation::where('conversation', '=', $aux);
                    if ($conversations->count() === 0) {
                        $conversation = Conversation::destroy($aux);
                    }
                    $result = 'delete';
                }
            } else {
                $itemConversation->name = "Este comentario se ha eliminado";
                if ($itemConversation->update()) {
                    $result = 'update';
                    $time = $itemConversation->updated_at->diffForHumans();
                }
            }
        } elseif ($request->type === 'AnswerTo') {
            ItemConversation::destroy($itemConversation->id);
            $result = 'delete';
        }

        return Response()->json(array('result' => $result, 'itemConversation' => $itemConversation, 'time' => $time));
    }

}
