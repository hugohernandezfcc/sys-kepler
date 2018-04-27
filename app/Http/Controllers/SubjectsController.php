<?php

namespace App\Http\Controllers;

use App\Subject;
use App\Conversation;
use App\ItemConversation;
use App\Area;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SubjectsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subjects', [
                'typeView'  => 'list',
                'records' => Subject::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Area  $areaId
     * @return \Illuminate\Http\Response
     */
    public function create($areaId = null)
    {
        if ($areaId !== null) {
            $area = Area::find($areaId);
        } else {
            $area = new Area();
        }
        $subject = new Subject();
        return view('subjects', [
                'typeView' => 'form',
                'record' => $subject,
                'to_related' => DB::table('areas')->get(),
                'area' => $area,
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
        $subject = new Subject();
        
        $subject->name = $request->name;
        $subject->area_id = $request->area_id;
        $subject->created_by = Auth::id();

        if($subject->save()){
            if ($request->groups != null) {
                $groups = explode(',', $request->groups);
                foreach ($groups as $group) {
                    $subject->groups()->attach($group, ['name' => $subject->name, 'created_by' => Auth::id()]);
                }
            }
            return redirect('/subjects/show/' . $subject->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subjectId
     * @return \Illuminate\Http\Response
     */
    public function show($subjectId)
    {
        $comments = [];
        $conversation = Conversation::where('table', '=', 'subjects')->where('id_record', '=', $subjectId)->orderBy('created_at', 'asc')->get();
        if (count($conversation) > 0) {
            $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

            $comments = $this->obtenerComentarios($questions, $conversation);
        }

        return view('subjects', [
                'typeView' => 'view',
                'record' => Subject::find($subjectId),
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
     * @param  \App\Subject  $subjectId
     * @return \Illuminate\Http\Response
     */
    public function edit($subjectId)
    {
        return view('subjects', [
                'typeView' => 'form',
                'to_related' => DB::table('areas')->get(),
                'record' => Subject::find($subjectId),
                'area' => new Area(),
                'groups' => DB::table('groups')->get()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $subject = Subject::find($request->idRecord);
        $subject->name = $request->name;
        $subject->area_id = $request->area_id;
        $subject->touch();
        if ($subject->update()) {
            $groupsSelected = ($request->groups !== null ? explode(',', $request->groups) : null);
            if ($subject->groups !== null) {
                foreach ($subject->groups as $groupSubject) {
                    $encontrado = false;
                    if ($groupsSelected !== null) {
                        foreach ($groupsSelected as $key => $user) {
                            if ($user == $groupSubject->id) {
                                $encontrado = true;
                                unset($groupsSelected[$key]);
                                break;
                            }
                        }
                    }
                    if (!$encontrado) {
                        $subject->groups()->detach($groupSubject->id);
                    }
                }
            }
            if ($groupsSelected !== null) {
                foreach ($groupsSelected as $group) {
                    if ($group !== '') {
                        $subject->groups()->attach($group, ['name' => $subject->name, 'created_by' => Auth::id()]);
                    }
                }
            }
            return redirect('/subjects/show/' . $subject->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
