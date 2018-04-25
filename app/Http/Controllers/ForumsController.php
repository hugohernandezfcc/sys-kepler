<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Conversation;
use App\ItemConversation;
use App\Module;
use App\QuestionForum;
use App\Vote;
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
        $ranString = openssl_random_pseudo_bytes(6);
        $name = bin2hex($ranString);

        $forum = new Forum();
        $forum->name = time().$name;
        $forum->module_id = $request->module_id;
        $forum->description = $request->description;
        $forum->created_by = Auth::id();
        if($forum->save()){
            return redirect('/forums/show/' . $forum->name);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\forum  $forumName
     * @return \Illuminate\Http\Response
     */
    public function show($forumName) {
        $forum = Forum::where('name', '=', $forumName)->first();
        if($forum) {
            $comments = [];
            $conversation = Conversation::where('table', '=', 'forums')->where('id_record', '=', $forum->id)->orderBy('created_at', 'asc')->get();
            if (count($conversation) > 0) {
                $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

                $comments = $this->obtenerComentarios($questions, $conversation);
            }
            $auxQuestions = [];
            foreach($forum->questionsforums as $question) {
                $votes = 0;
                $votes = $question->votes->where('type', '=', 'Positivo')->count() - $question->votes->where('type', '=', 'Negativo')->count();
                $question->cantVotes = $votes;
                $auxQuestions[] = $question;
            }
            return view('forums', [
                    'typeView' => 'view',
                    'record' => $forum,
                    'comments' => $comments,
                    'questionsForums' => collect($auxQuestions)
                ]
            );
        } else {
            return redirect()->to('home')->with('warning', 'Id de foro no encontrado.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\forum  $forumName
     * @return \Illuminate\Http\Response
     */
    public function showquestion($forumName, $questionId) {
        $forum = Forum::where('name', '=', $forumName)->first();
        if($forum) {
            $comments = [];
            $conversation = Conversation::where('table', '=', 'forums')->where('id_record', '=', $forum->id)->orderBy('created_at', 'asc')->get();
            if (count($conversation) > 0) {
                $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('name',  '=', $questionId)->first();
                
                $comments[0]['Question'] = $questions;
                $comments[0]['Answer'][0] = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent', '=', $questions->id)->orderBy('parent', 'asc')->get();
                if (count($comments[0]['Answer'][0]) > 0) {
                    foreach ($comments[0]['Answer'][0] as $key_answer => $answer) {
                        $comments[0]['Answer'][0][$key_answer]['AnswerToAnswer'] = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent', '=', $answer->id)->orderBy('parent', 'asc')->get();
                    }
                }
            }
            return view('forums', [
                    'typeView' => 'question',
                    'record' => $forum,
                    'comments' => $comments,
                    'question' => QuestionForum::find($questionId)
                ]
            );
        } else {
            return redirect()->to('login')->with('warning', 'Id de foro no encontrado.');
        }
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
    public function destroy($forumId) {
        $forum = Forum::find($forumId);

        //Eliminar las conversaciones asociadas
        $conversation = Conversation::where('table', '=', 'forums')->where('id_record', '=', $forum->id)->first();
        $items = $conversation->itemsconversations()->orderBy('created_at', 'desc')->get();
        foreach ($items as $item) {
            ItemConversation::destroy($item->id);
        }
        Conversation::destroy($conversation->id);

        //Eliminar las Preguntas y los Votos de cada Pregunta
        $questionsForums = $forum->questionsforums()->get();
        foreach ($questionsForums as $question) {
            $votes = $question->votes()->get();
            foreach ($votes as $vote) {
                Vote::destroy($vote->id);
            }
            QuestionForum::destroy($question->id);
        }
        
        //Finalmente se elimina el Foro
        Forum::destroy($forum->id);
        return redirect('/home');
    }
}
