<?php

namespace App\Http\Controllers;

use App\Area;
use App\Group;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if(Auth::user()->type == "admin") {
            $records['areas'] = count(Area::all());
            $records['students'] = count(User::where('type', '=', 'student')->get());
            $records['subjects'] = count(Subject::all());
            $records['groups'] = count(Group::all());
            $records['users'] = User::get(['name','email','created_at', 'type']);
            return view('home', [
                'typeView'  => 'list',
                'records' => $records
                ]
            );
        } elseif (Auth::user()->type == "student") {
            return view('home_student');
        } else {
            return view('home_master');
        }
    }

    /**
     * Busqueda global.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $search = $request->search;
        
        $areas = DB::table('areas')->select('areas.name', 'areas.created_at', 'areas.updated_at', 'users.name as created_by')->where('areas.name', 'ilike', '%'.$search.'%')->join('users', 'areas.created_by', '=', 'users.id');
        $articles = DB::table('articles')->select('articles.name', 'articles.created_at', 'articles.updated_at', 'users.name as created_by')->where('articles.name', 'ilike', '%'.$search.'%')->join('users', 'articles.created_by', '=', 'users.id');
        $exams = DB::table('exams')->select('exams.name', 'exams.created_at', 'exams.updated_at', 'users.name as created_by')->where('exams.name', 'ilike', '%'.$search.'%')->join('users', 'exams.created_by', '=', 'users.id');
        $forums = DB::table('forums')->select('forums.name', 'forums.created_at', 'forums.updated_at', 'users.name as created_by')->where('forums.name', 'ilike', '%'.$search.'%')->join('users', 'forums.created_by', '=', 'users.id');
        $links = DB::table('links')->select('links.name', 'links.created_at', 'links.updated_at', 'users.name as created_by')->where('links.name', 'ilike', '%'.$search.'%')->join('users', 'links.created_by', '=', 'users.id');
        $posts = DB::table('posts')->select('posts.name', 'posts.created_at', 'posts.updated_at', 'users.name as created_by')->where('posts.name', 'ilike', '%'.$search.'%')->join('users', 'posts.created_by', '=', 'users.id');
        $questions_forums = DB::table('questions_forums')->select('questions_forums.name', 'questions_forums.created_at', 'questions_forums.updated_at', 'users.name as created_by')->where('questions_forums.name', 'ilike', '%'.$search.'%')->join('users', 'questions_forums.created_by', '=', 'users.id');
        $subjects = DB::table('subjects')->select('subjects.name', 'subjects.created_at', 'subjects.updated_at', 'users.name as created_by')->where('subjects.name', 'ilike', '%'.$search.'%')->join('users', 'subjects.created_by', '=', 'users.id');
        $tasks = DB::table('tasks')->select('tasks.name', 'tasks.created_at', 'tasks.updated_at', 'users.name as created_by')->where('tasks.name', 'ilike', '%'.$search.'%')->join('users', 'tasks.created_by', '=', 'users.id');
        $walls = DB::table('walls')->select('walls.name', 'walls.created_at', 'walls.updated_at', 'users.name as created_by')->where('walls.name', 'ilike', '%'.$search.'%')->join('users', 'walls.created_by', '=', 'users.id');
        
        $unionSearch = $areas->union($articles)->union($exams)->union($forums)->union($links)
            ->union($posts)->union($questions_forums)->union($subjects)->union($tasks)->union($walls)->get();
            
        return Response()->json(array('result' => 'ok', 'globalResult' => $unionSearch));
    }
}
