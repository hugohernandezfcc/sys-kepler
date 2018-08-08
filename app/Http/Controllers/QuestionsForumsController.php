<?php

namespace App\Http\Controllers;

use App\QuestionForum;
use App\Conversation;
use App\ItemConversation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsForumsController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct() {
        $this->middleware('auth')->except('storeGuest');;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        return $this->storeQuestion($request, $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGuest(Request $request)
    {
        $user = (object)['id' => $request->nameUserGuest];
        return $this->storeQuestion($request, $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeQuestion($request, $user)
    {
        $questionforum = new QuestionForum();

        $questionforum->name = $request->name;
        $questionforum->body = $request->body;
        $questionforum->forum_id = $request->forumId;
        $questionforum->created_by = $user->id;

        if($questionforum->save()) {
            $table = 'forums';
            $idRecord = $request->forumId;
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
            $itemConversation->type = 'Question';
            $itemConversation->parent = null;
            $itemConversation->name = $questionforum->id;
            $itemConversation->by = $user->id;
            $itemConversation->conversation = $conversation->id;
            if($itemConversation->save()){
                return redirect('/forums/'.$questionforum->forum->name.'/question/'.$questionforum->id);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuestionForum  $questionForum
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionForum $questionForum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuestionForum  $questionForum
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionForum $questionForum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuestionForum  $questionForum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionForum $questionForum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuestionForum  $questionForum
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionForum $questionForum)
    {
        //
    }
}
