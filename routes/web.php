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


Route::get('/groups', function () {
	return view('groups');
});

Route::group(['prefix' => 'subjects'], function(){
	Route::get('/', [
			'uses'	=>	'SubjectsController@index',
			'as'	=>	'subjects'
		]
	);

	Route::get('/create', [
			'uses'	=>	'SubjectsController@create',
			'as'	=>	'create'
		]
	);
});





use App\User;
/* Ruta de prueba del template */
Route::get('/update', function () {

	$user = User::find(1);
	//'master', '', 'student'
	$user->type = "admin";

	$user->save();

	dd($user);
});
