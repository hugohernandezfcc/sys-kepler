<?php

namespace App\Http\Controllers;

use App\Wall;
use App\Conversation;
use App\ItemConversation;
use App\Module;
use App\Post;
use App\Like;
use Jenssegers\Agent\Agent;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WallsController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct() {
        $this->middleware('auth')->except('show');;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('walls', [
            'typeView'  => 'list',
            'records' => Wall::all()
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read() {
        $walls = Wall::all();

        return $walls;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($moduleId = null) {
        if ($moduleId !== null) {
            $module = Module::find($moduleId);
        } else {
            $module = new Module();
        }
        $wall = new Wall();
        return view('walls', [
                'typeView' => 'form',
                'record' => $wall,
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

        $wall = new Wall();
        $wall->name = time().$name;
        $wall->description = $request->description;
        $wall->created_by = Auth::id();
        $wall->module_id = $request->module_id;

        if($wall->save()){
            $this->storeFirstPost($wall);
            return redirect('/walls');
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

    #$user = new App\User(['id' => 10, 'avatar' => 'default.jpg', 'email' => 'prueba@uno.com', 'password' => '12345']);
    #Auth::guard()->login($user);
    #var_dump($user);
    
    /**
     * Display the specified resource.
     *
     * @param  \App\wall  $wallName
     * @return \Illuminate\Http\Response
     */
    public function show($wallName) {
        $wall = Wall::where('name', '=', $wallName)->first();
        if($wall) {
            $agent = new Agent();
            $comments = [];
            $conversation = Conversation::where('table', '=', 'walls')->where('id_record', '=', $wall->id)->orderBy('created_at', 'asc')->get();
            if (count($conversation) > 0) {
                $questions = ItemConversation::where('conversation', '=', $conversation[0]->id)->where('parent',  '=', null)->orderBy('created_at', 'desc')->get();

                $comments = $this->obtenerComentarios($questions, $conversation);
            }
            return view('walls', [
                'typeView' => 'view',
                'record' => $wall,
                'comments' => $comments,
                'agent' => $agent
                ]
            );
        } else {
            return redirect()->to('login')->with('warning', 'Id de muro no encontrado.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\wall  $wallName
     * @return \Illuminate\Http\Response
     */
    public function showdetail($wallName) {
        $wall = Wall::where('name', '=', $wallName)->first();
        if($wall) {
           /* foreach ($wall->module->subject->groups as $group){
                dd($group);
                foreach ($group->users as $groupUser) {
                    var_dump($groupUser);
                }
            }
            dd('strop'); */
            return view('walls', [
                'typeView'  => 'detail',
                'record' => $wall
                ]
            );
        } else {
            return redirect()->to('home')->with('warning', 'Id de muro no encontrado.');
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
     * @param  \App\wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function edit(Wall $wall) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wall $wall) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\wall  $wallId
     * @return \Illuminate\Http\Response
     */
    public function destroy($wallId) {
        $wall = Wall::find($wallId);

        //Eliminar las conversaciones asociadas
        $conversation = Conversation::where('table', '=', 'walls')->where('id_record', '=', $wall->id)->first();
        $items = $conversation->itemsconversations()->orderBy('created_at', 'desc')->get();
        foreach ($items as $item) {
            ItemConversation::destroy($item->id);
        }
        Conversation::destroy($conversation->id);

        //Eliminar los Posts y los Likes de cada Post
        $posts = $wall->posts()->get();
        foreach ($posts as $post) {
            $likes = $post->likes()->get();
            foreach ($likes as $like) {
                Like::destroy($like->id);
            }
            Post::destroy($post->id);
        }
        
        //Finalmente se elimina el Muro
        Wall::destroy($wall->id);
        return redirect('/home');
    }
}
