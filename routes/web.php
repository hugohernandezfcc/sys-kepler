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

Route::group(['prefix' => 'cyclescontrol'], function(){
	Route::get('/', [
			'uses'	=>	'SchoolCyclesController@index',
			'as'	=>	'index'
		]
	);

	Route::get('/create', [
			'uses'	=>	'SchoolCyclesController@create',
			'as'	=>	'create'
		]
	);

	Route::get('/show/{schoolCycleId}', [
			'uses'	=>	'SchoolCyclesController@show',
			'as'	=>	'show'
		]
	);

	Route::post('/store', [
			'uses'	=>	'SchoolCyclesController@store',
			'as'	=>	'store'
		]
	);
});

Route::group(['prefix' => 'areas'], function(){
	Route::get('/', [
			'uses'	=>	'AreasController@index',
			'as'	=>	'index'
		]
	);

	Route::get('/create', [
			'uses'	=>	'AreasController@create',
			'as'	=>	'create'
		]
	);

	Route::get('/show/{areaId}', [
			'uses'	=>	'AreasController@show',
			'as'	=>	'show'
		]
	);

	Route::post('/store', [
			'uses'	=>	'AreasController@store',
			'as'	=>	'store'
		]
	);
});

Route::group(['prefix' => 'subjects'], function(){
	Route::get('/', [
			'uses'	=>	'SubjectsController@index',
			'as'	=>	'index'
		]
	);

	Route::get('/create', [
			'uses'	=>	'SubjectsController@create',
			'as'	=>	'create'
		]
	);

	Route::post('/store', [
			'uses'	=>	'SubjectsController@store',
			'as'	=>	'store'
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
