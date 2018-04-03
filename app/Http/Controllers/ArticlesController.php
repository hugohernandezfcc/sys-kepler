<?php

namespace App\Http\Controllers;

use App\Article;
use App\Conversation;
use App\ItemConversation;
use App\Module;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
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
        return view('articles', [
                'typeView'  => 'list',
                'records' => Article::orderBy('created_at', 'desc')
                                ->get()
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
        $article = new Article();
        return view('articles', [
                'typeView' => 'form',
                'record' => $article,
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
        $article = new Article();
        $article->name = $request->name;
        $article->contenido = $request->contenido;
        $article->created_by = Auth::id();
        $article->module_id = $request->module_id;
        if ($article->save()) {
            return redirect('/articles/show/' . $article->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\article  $articleId
     * @return \Illuminate\Http\Response
     */
    public function show($articleId) {
        $comments = [];
        $conversation = Conversation::where('table', '=', 'articles')->where('id_record', '=', $articleId)->orderBy('created_at', 'asc')->get();
        if (count($conversation) > 0) {
            $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

            $comments = $this->obtenerComentarios($questions, $conversation);
        }
        return view('articles', [
                'typeView' => 'view',
                'record' => Article::find($articleId),
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
     * @param  \App\article  $articleId
     * @return \Illuminate\Http\Response
     */
    public function edit($articleId) {
        return view('articles', [
                'typeView' => 'form',
                'record' => Article::find($articleId),
                'to_related' => DB::table('modules')->get(),
                'module' => new Module()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $article = Article::find($request->idRecord);
        $article->name = $request->name;
        $article->module_id = $request->module_id;
        $article->contenido = $request->contenido;
        if ($article->update()) {
            return redirect('/articles/show/' . $article->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article) {
        $article->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}