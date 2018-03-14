<?php

namespace App\Http\Controllers;

use Auth;
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
        
        /*$auxCamposUsers = Schema::getColumnListing('users');
        for ($i=9; $i<count($auxCamposUsers); ++$i) {
            $campo = $auxCamposUsers[$i];
            $user->$campo = $request->$campo;
        }*/

        if ($user->update()) {
            return redirect('/profile');
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
            $aux = Inscription::where('id', '=', Auth::user()->inscription_id)->firts();
            $auxCamposUsers = explode('-', $aux->columns_name);
            foreach ($auxCamposUsers as $key => $value) {
                $type = Schema::getColumnType('users', $value);
                $camposUsers[$key] = ['tipo' => $type, 'valor' => $value];
            }
        }
        return $camposUsers;
    }

}
