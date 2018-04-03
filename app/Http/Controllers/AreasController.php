<?php

namespace App\Http\Controllers;

use App\Area;
use App\Conversation;
use App\ItemConversation;
use App\SchoolCycle;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AreasController extends Controller
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
        return view('area', [
                'typeView'  => 'list',
                'records' => Area::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\SchoolCycle  $schoolCycleId
     * @return \Illuminate\Http\Response
     */
    public function create($schoolCycleId = null)
    {
        if ($schoolCycleId !== null) {
            $schoolCycle = SchoolCycle::find($schoolCycleId);
        } else {
            $schoolCycle = new SchoolCycle();
        }
        $area = new Area();
        return view('area', [
                'typeView' => 'form',
                'record' => $area,
                'to_related' => DB::table('school_cycles')->get(),
                'schoolCycle' => $schoolCycle
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
        $Area = new Area();

        $Area->name = $request->name;
        $Area->school_cycle_id = $request->school_cycle_id;
        $Area->description = $request->description;
        $Area->created_by = Auth::id();


        if($Area->save()){
            return redirect('/areas/show/' . $Area->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $areaId
     * @return \Illuminate\Http\Response
     */
    public function show($areaId)
    {
        $comments = [];
        $conversation = Conversation::where('table', '=', 'areas')->where('id_record', '=', $areaId)->orderBy('created_at', 'asc')->get();
        if (count($conversation) > 0) {
            $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'asc')->get();

            $comments = $this->obtenerComentarios($questions, $conversation);
        }

        return view('area', [
                'typeView' => 'view',
                'record' => Area::find($areaId),
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
     * @param  \App\Area  $areaId
     * @return \Illuminate\Http\Response
     */
    public function edit($areaId)
    {
        return view('area', [
                'typeView' => 'form',
                'to_related' => DB::table('school_cycles')->get(),
                'record' => Area::find($areaId),
                'schoolCycle' => new SchoolCycle()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $area = Area::find($request->idRecord);
        $area->name = $request->name;
        $area->description = $request->description;
        $area->school_cycle_id = $request->school_cycle_id;
        if ($area->update()) {
            return redirect('/areas/show/' . $area->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->route('nombre_ruta_destino');
    }
}
