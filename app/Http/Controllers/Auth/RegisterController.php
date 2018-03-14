<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Column;
use App\Inscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return redirect()->to('login')->with('warning', 'El registro de usuarios está desactivado');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $inscription = Inscription::where('name', '=', $data['inscriptionName'])->first();
        $columnsRequired = Column::where('required', '=', true)->get();
        $columnsAditional = Column::whereIn('name', explode('-', $inscription->columns_name))->get();
        $columns = $columnsRequired->merge($columnsAditional);
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->type = $inscription->type_user;
        $user->inscription_id = $inscription->id;
        foreach ($columns as $column) {
            $columnName = $column->name;
            $user->$columnName = $data[$columnName];
        }
        if ($user->save()) {
            return $user;
        }
    }
    
    protected function getRegister($inscriptionId) {
        $inscription = Inscription::where('name', '=', $inscriptionId)->first();
        if($inscription) {
            $columnsRequired = Column::where('required', '=', true)->get();
            $columnsAditional = Column::whereIn('name', explode('-', $inscription->columns_name))->get();
            $columns = $columnsRequired->merge($columnsAditional);
            return view('auth.register', [
                    'typeView' => 'inscription',
                    'inscriptionName' => $inscriptionId,
                    'columns' => $columns
                ]
            );
        } else {
            return redirect()->to('login')->with('warning', 'Id de inscripción no encontrado.');
        }
    }
}
