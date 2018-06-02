<?php

namespace App\Http\Controllers;

use App\SchoolCycle;
use App\Area;
use App\Subject;
use App\Module;
use App\Wall;
use App\Forum;
use App\Article;
use App\Post;
use App\Conversation;
use App\ItemConversation;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class WizardsController extends Controller
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
        return view('wizards', [
                'typeView' => 'view',
                'groups' => DB::table('groups')->get()
            ]
        );   
    }
    
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCosts() {
        return view('wizards', [
                'typeView' => 'viewCosts',
                'courses' => SchoolCycle::all(),
                'users' => User::where('type', '!=', 'admin')->get(['name','email','created_at', 'type'])->groupBy('type')
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
            $areas = explode(',', $request->areas);
            foreach ($areas as $areaName) {
                $Area = new Area();
                $Area->name = $areaName;
                $Area->school_cycle_id = $SchoolCycle->id;
                $Area->created_by = Auth::id();
                $Area->save();
            }
            $listSubjects = explode(',', $request->subjects);
            $groups = explode(',', $request->groups);
            foreach ($listSubjects as $subjectArea) {
                $subjectAreaNames = explode(' / ', $subjectArea);
                $area = Area::where('name', '=', $subjectAreaNames[1])->where('school_cycle_id', '=', $SchoolCycle->id)->first();
                $subject = new Subject();
                
                $subject->name = $subjectAreaNames[0];
                $subject->area_id = $area->id;
                $subject->created_by = Auth::id();
                $subject->save();

                foreach ($groups as $group) {
                    $subject->groups()->attach($group, ['name' => $subject->name, 'created_by' => Auth::id()]);
                }
            }

            if ($request->muro === 'on' || $request->foro === 'on' || $request->articulo === 'on') {
                $subjectAreaArray = $request->selectSubjectArea;
                foreach ($subjectAreaArray as $subjectAreaName) {
                    $subjectAreaNames = explode(' / ', $subjectAreaName);
                    $area = Area::where('name', '=', $subjectAreaNames[1])->where('school_cycle_id', '=', $SchoolCycle->id)->first();
                    $subject = Subject::where('name', '=', $subjectAreaNames[0])->where('area_id', '=', $area->id)->first();
                    if ($subject !== null) {
                        $module = new Module();
                        $module->name = $subject->name;
                        $module->subject_id = $subject->id;
                        $module->created_by = Auth::id();
                        $module->save();

                        if ($request->muro === 'on') {
                            $ranString = openssl_random_pseudo_bytes(6);
                            $name = bin2hex($ranString);

                            $wall = new Wall();
                            $wall->name = time().$name;
                            $wall->description = $subject->name;
                            $wall->created_by = Auth::id();
                            $wall->module_id = $module->id;

                            if($wall->save()){
                                $this->storeFirstPost($wall);
                            }
                        }
                        if ($request->foro === 'on') {
                            $ranString = openssl_random_pseudo_bytes(6);
                            $name = bin2hex($ranString);

                            $forum = new Forum();
                            $forum->name = time().$name;
                            $forum->module_id = $module->id;
                            $forum->description = $subject->name;
                            $forum->created_by = Auth::id();
                            $forum->save();
                        }
                        if ($request->articulo === 'on') {
                            $article = new Article();
                            $article->name = $subject->name;
                            $article->contenido = $area->name;
                            $article->created_by = Auth::id();
                            $article->module_id = $module->id;
                            $article->save();
                        }
                    }
                }
            }
            return redirect('/home');
        }
    }

    /**
     * 
     */
    public function storeFirstPost($wall)
    {
        $post = new Post();
        $post->name = $wall->name;
        $post->body = $wall->description;
        $post->created_by = Auth::id();
        $post->wall_id = $wall->id;
        if ($post->save()) {
            $conversation = new Conversation();
            $conversation->name = $wall->name;
            $conversation->table = 'walls';
            $conversation->id_record = $wall->id;
            if ($conversation->save()) {
                $itemConversation = new ItemConversation();
                $itemConversation->type = 'Question';
                $itemConversation->parent = null;
                $itemConversation->name = $post->id;
                $itemConversation->by = Auth::id();
                $itemConversation->conversation = $conversation->id;
                $itemConversation->save();
            }
        }
    }
}

