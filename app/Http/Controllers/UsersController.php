<?php

namespace App\Http\Controllers;

use Auth;
use App\Column;
use App\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests;
use Image;
use File;

class UsersController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $userId
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('profile', [
            'typeView' => 'view',
            'camposUsers' => $this->camposUsers()
                ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inscriptions() {
        if (Auth::user()->type == 'admin') {
            return view('profile', [
                'typeView' => 'list',
                'records' => Inscription::all()
                    ]
            );
        } else {
            return redirect('/profile');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $userId
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        return view('profile', [
            'typeView' => 'form',
            'camposUsers' => $this->camposUsers()
                ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $user = Auth::user();
        $user->name = $request->get('name');

        // Handle the user upload of avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            // Delete current image before uploading new image
            if ($user->avatar !== 'default.jpg') {
                $file = public_path('uploads/avatars/' . $user->avatar);
                if (File::exists($file)) {
                    unlink($file);
                }
            }
            Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatars/' . $filename));

            $user->avatar = $filename;
        }
        
        $auxCamposUsers = $this->camposUsers();
        foreach ($auxCamposUsers as $column) {
            $valorCampo = $column->name;
            $user->$valorCampo = $request->$valorCampo;
        }

        if ($user->update()) {
            return redirect('/profile');
        }
    }

    
    /**
     * storeImage a new Image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request) {
        if ($request->hasFile('avatar')) {
            $user = Auth::user();

            $avatar = $request->file('avatar');
            $filename = $user->id . '.png';
            // Delete current image before uploading new image
            if ($user->avatar !== 'default.jpg') {
                $file = public_path('uploads/avatars/' . $user->avatar);
                if (File::exists($file)) {
                    unlink($file);
                }
            }
            Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatars/' . $filename));

            $user->avatar = $filename;
            if ($user->update()) {
                return response()->json(['state'   => 200,
                'message' => 'success',
                'ruta' => asset("uploads/avatars/". $user->avatar)]);
            }
        }
    }
    
    /**
     * 
     * 
     * @return array
     */
    protected function camposUsers() {
        $camposUsers=[];
        if(Auth::user()->inscription_id !== null) {
            $inscription = Inscription::where('id', '=', Auth::user()->inscription_id)->first();
            $columnsRequired = Column::where('required', '=', true)->get();
            $columnsAditional = Column::whereIn('name', explode('-', $inscription->columns_name))->get();
            $camposUsers = $columnsRequired->merge($columnsAditional);
        }
        return $camposUsers;
    }

}
