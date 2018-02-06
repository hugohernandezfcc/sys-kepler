<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */



Auth::routes();
Route::redirect('/', '/login', 301);

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'cyclescontrol'], function() {
    Route::get('/', [
        'uses' => 'SchoolCyclesController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'SchoolCyclesController@create',
        'as' => 'create'
            ]
    );

    Route::get('/show/{schoolCycleId}', [
        'uses' => 'SchoolCyclesController@show',
        'as' => 'show'
            ]
    );

    Route::post('/store', [
        'uses' => 'SchoolCyclesController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'areas'], function() {
    Route::get('/', [
        'uses' => 'AreasController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'AreasController@create',
        'as' => 'create'
            ]
    );

    Route::get('/show/{areaId}', [
        'uses' => 'AreasController@show',
        'as' => 'show'
            ]
    );

    Route::post('/store', [
        'uses' => 'AreasController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'subjects'], function() {
    Route::get('/', [
        'uses' => 'SubjectsController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'SubjectsController@create',
        'as' => 'create'
            ]
    );

    Route::post('/store', [
        'uses' => 'SubjectsController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'groups'], function() {
    Route::get('/', [
        'uses' => 'GroupsController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'GroupsController@create',
        'as' => 'create'
            ]
    );

    Route::get('/show/{groupId}', [
        'uses' => 'GroupsController@show',
        'as' => 'show'
            ]
    );

    Route::post('/store', [
        'uses' => 'GroupsController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'conversations'], function() {
    Route::post('/store', [
        'uses' => 'ConversationsController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'profile'], function() {
    Route::get('/', [
        'uses' => 'UsersController@index',
        'as' => 'index'
            ]
    );

    Route::post('/store', [
        'uses' => 'UsersController@store',
        'as' => 'store'
            ]
    );

    Route::get('/edit', [
        'uses' => 'UsersController@edit',
        'as' => 'edit'
            ]
    );

    Route::post('/update', [
        'uses' => 'UsersController@update',
        'as' => 'update'
            ]
    );
});

//use Session;
//use Auth;
Route::get('/logout', function() {
    Session::forget('key');
    if (!Session::has('key')) {
        Auth::logout();

        Session::flush();

        return redirect('/');
    }
});

use App\User;

/* Ruta de prueba del template */
Route::get('/update', function () {

    $user = User::find(4);
    //'master', '', 'student'
    $user->type = "master";

    $user->save();

    dd($user);
});
