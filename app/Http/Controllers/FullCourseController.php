<?php

namespace App\Http\Controllers;

use App\SchoolCycle;
use App\Conversation;
use App\ItemConversation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FullCourseController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fullcourse', [
                'typeView' => 'view',
                'groups' => DB::table('groups')->get()
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
            return redirect('/courses/show/' . $SchoolCycle->id);
        }
    }
}
