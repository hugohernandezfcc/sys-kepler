<?php

namespace App\Http\Controllers;

use App\Vote;
use App\QuestionForum;
use Auth;
use Illuminate\Http\Request;

class VotesController extends Controller
{
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
        $question = QuestionForum::find($request->questionId);
        $votesPartials = $question->votes->where('type', '=', 'Positivo')->count() - $question->votes->where('type', '=', 'Negativo')->count();
        $aux = $question->votes->where('question_forum', '=', $question->id)->firstwhere('by', '=', Auth::user()->id);
        if ($aux === null) {
            $vote = new Vote();
            $vote->name = $question->name;
            $vote->type = $request->option;
            $vote->by = Auth::user()->id;
            $vote->question_forum = $question->id;
            $vote->save();
            $cant = 1;
            $answer = 'new';
        } else {
            $aux->type = $request->option;
            $aux->update();
            $cant = 2;
            $answer = 'updated';
        }
        if ($request->option === 'Positivo') {
            $votes = $votesPartials + $cant;
        } else {
            $votes = $votesPartials - $cant;
        }
        return response()->json(array('votes' => $votes, 'answer' => $answer));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }
}
