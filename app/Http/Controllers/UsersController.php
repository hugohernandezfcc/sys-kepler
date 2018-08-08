<?php

namespace App\Http\Controllers;

use Auth;
use App\Column;
use App\Inscription;
use App\User;
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
        $this->middleware('auth')->except('storeGuest');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId = null) {
        if ($userId !== null && $userId != Auth::user()->id) {
            $edit = false;
            $user = User::find($userId);
        } else {
            $edit = true;
            $user = Auth::user();
        }
        return view('profile', [
            'typeView' => 'view',
            'camposUsers' => $this->camposUsers($userId),
            'edit' => $edit,
            'user' => $user
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
     * StoreGuest a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGuest(Request $request)
    {
        $userFind = User::where('email', '=', $request->email)->first();
        $result = 'unauthorized';
        if ($userFind === null) {
            #Nuevo usuario invitado
            $user = new User();
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt('Kepler123');
            $user->avatar = 'default.jpg';

            if ($user->save()) {
                $result = 'new';
            }
        } else {
            if ($userFind->type === null) {
                #Usuario invitado existente
                if ($userFind->name == $request->name) {
                    #Si coincide su nombre y correo se permite comentar
                    $result = 'exists';
                    $user = $userFind;
                } else {
                    #Sino coincide su nombre y correo, no se permite comentar
                    $user = (object)['name' => '', 'email' => '', 'id' => null, 'avatar' => ''];
                }
            } else {
                #Usuario del sistema (debe autenticarse)
                $user = (object)['name' => '', 'email' => '', 'id' => null, 'avatar' => ''];
            }
        }
        return Response()->json(array('result' => $result, 'user' => $user));
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
                'otra_ruta' => str_replace('"\"', '', asset("uploads/avatars/". $user->avatar)),
                'ruta' => asset("uploads/avatars/". $user->avatar)]);
            }
        }
    }
    
    /**
     * 
     * 
     * @return array
     */
    protected function camposUsers($userId = null) {
        $camposUsers=[];
        if ($userId !== null) {
            $aux = User::where('id', '=', $userId)->first();
            $inscriptionId = $aux->inscription_id;
        } else {
            $inscriptionId = Auth::user()->inscription_id;
        }
        if($inscriptionId !== null) {
            $inscription = Inscription::where('id', '=', $inscriptionId)->first();
            $columnsRequired = Column::where('required', '=', true)->get();
            $columnsAditional = Column::whereIn('name', explode('-', $inscription->columns_name))->get();
            $camposUsers = $columnsRequired->merge($columnsAditional);
        }
        return $camposUsers;
    }

}
