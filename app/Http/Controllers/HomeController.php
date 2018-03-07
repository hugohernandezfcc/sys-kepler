<?php

namespace App\Http\Controllers;

use App\Area;
use App\Group;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
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
}
