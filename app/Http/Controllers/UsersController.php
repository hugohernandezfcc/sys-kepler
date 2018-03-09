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
        $camposUsers = Schema::getColumnListing('users');
        for ($i=0; $i<8; ++$i) {
            unset($camposUsers[$i]);
        }
        return view('profile', [
            'typeView' => 'view',
            'record' => Auth::user(),
            'camposUsers' => $camposUsers
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
        $auxCamposUsers = Schema::getColumnListing('users');
        for ($i=0; $i<8; ++$i) {
            unset($auxCamposUsers[$i]);
        }
        foreach ($auxCamposUsers as $key => $value) {
            $type = Schema::getColumnType('users', $value);
            $camposUsers[$key] = ['tipo' => $type, 'valor' => $value];
        }
        return view('profile', [
            'typeView' => 'form',
            'record' => Auth::user(),
            'camposUsers' => $camposUsers
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

        if ($user->update()) {
            return redirect('/profile');
        }
    }

}
