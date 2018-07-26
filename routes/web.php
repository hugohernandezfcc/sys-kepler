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

Route::group(['prefix' => 'register'], function() {
    Route::get('/{inscriptionID}', [
        'uses' => 'Auth\RegisterController@getRegister',
        'as' => 'getRegister'
        ]
    );
    
    Route::post('/store', [
        'uses' => 'Auth\RegisterController@store',
        'as' => 'store'
        ]
    );
}); 
Auth::routes();
Route::redirect('/', '/login', 301);


Route::group(['prefix' => 'home'], function() {
    Route::get('/', [
        'uses' => 'HomeController@index',
        'as' => 'index'
        ]
    )->name('home');
    
    Route::post('/search', [
        'uses' => 'HomeController@search',
        'as' => 'search'
        ]
    );
});


Route::group(['prefix' => 'courses'], function() {
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

    Route::get('/edit/{schoolCycleId}', [
        'uses' => 'SchoolCyclesController@edit',
        'as' => 'edit'
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
    
    Route::put('/update', [
        'uses' => 'SchoolCyclesController@update',
        'as' => 'update'
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

    Route::get('/create/{schoolCycleId}', [
        'uses' => 'AreasController@create',
        'as' => 'create'
            ]
    );

    Route::get('/edit/{areaId}', [
        'uses' => 'AreasController@edit',
        'as' => 'edit'
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
    
    Route::put('/update', [
        'uses' => 'AreasController@update',
        'as' => 'update'
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
    
    Route::get('/create/{areaId}', [
        'uses' => 'SubjectsController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/edit/{subjectId}', [
        'uses' => 'SubjectsController@edit',
        'as' => 'edit'
            ]
    );

    Route::get('/show/{subjectId}', [
        'uses' => 'SubjectsController@show',
        'as' => 'show'
            ]
    );

    Route::post('/store', [
        'uses' => 'SubjectsController@store',
        'as' => 'store'
            ]
    );
    
    Route::put('/update', [
        'uses' => 'SubjectsController@update',
        'as' => 'update'
            ]
    );
});

Route::group(['prefix' => 'modules'], function() {
    Route::get('/', [
        'uses' => 'ModulesController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'ModulesController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/create/{subjectId}', [
        'uses' => 'ModulesController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/edit/{moduleId}', [
        'uses' => 'ModulesController@edit',
        'as' => 'edit'
            ]
    );

    Route::get('/show/{moduleId}', [
        'uses' => 'ModulesController@show',
        'as' => 'show'
            ]
    );

    Route::post('/store', [
        'uses' => 'ModulesController@store',
        'as' => 'store'
            ]
    );
    
    Route::put('/update', [
        'uses' => 'ModulesController@update',
        'as' => 'update'
            ]
    );
});

Route::group(['prefix' => 'list'], function() {
    Route::get('/', [
        'uses' => 'RollOfListsController@index',
        'as' => 'index'
            ]
    );

    Route::get('/show/{groupId}', [
        'uses' => 'RollOfListsController@show',
        'as' => 'show'
            ]
    );

    Route::post('/store', [
        'uses' => 'RollOfListsController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'links'], function() {
    Route::get('/', [
        'uses' => 'LinksController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'LinksController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/create/{moduleId}', [
        'uses' => 'LinksController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/edit/{linkId}', [
        'uses' => 'LinksController@edit',
        'as' => 'edit'
            ]
    );

    Route::get('/show/{linkId}', [
        'uses' => 'LinksController@show',
        'as' => 'show'
            ]
    );

    Route::post('/store', [
        'uses' => 'LinksController@store',
        'as' => 'store'
            ]
    );
    
    Route::put('/update', [
        'uses' => 'LinksController@update',
        'as' => 'update'
            ]
    );
});

Route::group(['prefix' => 'articles'], function() {
    Route::get('/', [
        'uses' => 'ArticlesController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'ArticlesController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/create/{moduleId}', [
        'uses' => 'ArticlesController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/edit/{articleId}', [
        'uses' => 'ArticlesController@edit',
        'as' => 'edit'
            ]
    );

    Route::get('/show/{articleId}', [
        'uses' => 'ArticlesController@show',
        'as' => 'show'
            ]
    );

    Route::post('/store', [
        'uses' => 'ArticlesController@store',
        'as' => 'store'
            ]
    );
    
    Route::put('/update', [
        'uses' => 'ArticlesController@update',
        'as' => 'update'
            ]
    );
});

Route::group(['prefix' => 'forums'], function() {
    Route::get('/', [
        'uses' => 'ForumsController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'ForumsController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/create/{moduleId}', [
        'uses' => 'ForumsController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/edit/{forumId}', [
        'uses' => 'ForumsController@edit',
        'as' => 'edit'
            ]
    );

    Route::get('/show/{forumName}', [
        'uses' => 'ForumsController@show',
        'as' => 'show'
            ]
    );

    Route::get('/{forumName}/question/{questionId}', [
        'uses' => 'ForumsController@showquestion',
        'as' => 'showquestion'
            ]
    );

    Route::post('/store', [
        'uses' => 'ForumsController@store',
        'as' => 'store'
            ]
    );
    
    Route::put('/update', [
        'uses' => 'ForumsController@update',
        'as' => 'update'
            ]
    );

    Route::delete('/{forumId}', [
        'uses' => 'ForumsController@destroy',
        'as' => 'destroy'
            ]
    );
});

Route::group(['prefix' => 'test'], function() {
    Route::get('/', [
        'uses' => 'ExamsController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'ExamsController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/create/{subjectId}', [
        'uses' => 'ExamsController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/show/{examId}', [
        'uses' => 'ExamsController@show',
        'as' => 'show'
            ]
    );
    
    Route::post('/store', [
        'uses' => 'ExamsController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'task'], function() {
    Route::get('/', [
        'uses' => 'TasksController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'TasksController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/create/{subjectId}', [
        'uses' => 'TasksController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/show/{taskId}', [
        'uses' => 'TasksController@show',
        'as' => 'show'
            ]
    );
    
    Route::post('/store', [
        'uses' => 'TasksController@store',
        'as' => 'store'
            ]
    );
    
    Route::post('/storeapplytask', [
        'uses' => 'TasksController@storeapplytask',
        'as' => 'storeapplytask'
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

    Route::get('/create/{subjectId}', [
        'uses' => 'GroupsController@create',
        'as' => 'create'
            ]
    );

    Route::get('/edit/{groupId}', [
        'uses' => 'GroupsController@edit',
        'as' => 'edit'
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

    Route::put('/update', [
        'uses' => 'GroupsController@update',
        'as' => 'update'
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

Route::group(['prefix' => 'itemsconversations'], function() {
    Route::post('/destroy', [
        'uses' => 'ItemsConversationsController@destroy',
        'as' => 'destroy'
            ]
    );
});

Route::group(['prefix' => 'questionsforums'], function() {
    Route::post('/store', [
        'uses' => 'QuestionsForumsController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'votes'], function() {
    Route::post('/store', [
        'uses' => 'VotesController@store',
        'as' => 'store'
            ]
    );
});

Route::group(['prefix' => 'post'], function() {
    Route::post('/store', [
        'uses' => 'PostsController@store',
        'as' => 'store'
            ]
    );

    Route::post('/storeLike', [
        'uses' => 'PostsController@storeLike',
        'as' => 'storeLike'
            ]
    );
});

Route::group(['prefix' => 'applytests'], function() {
    Route::post('/store', [
        'uses' => 'ApplyExamsController@store',
        'as' => 'store'
            ]
    );
    
    Route::post('/storeanswers', [
        'uses' => 'ApplyExamsController@storeanswers',
        'as' => 'storeanswers'
            ]
    );
    
    Route::get('/taketest/{applyExamName}', [
        'uses' => 'ApplyExamsController@takeexam',
        'as' => 'takeexam'
            ]
    );
});

Route::group(['prefix' => 'applytasks'], function() {
    Route::post('/store', [
        'uses' => 'ApplyTasksController@store',
        'as' => 'store'
            ]
    );
    
    Route::post('/storeanswers', [
        'uses' => 'ApplyTasksController@storeanswers',
        'as' => 'storeanswers'
            ]
    );
    
    Route::get('/taketask/{applyTaskName}', [
        'uses' => 'ApplyTasksController@taketask',
        'as' => 'taketask'
            ]
    );
});

Route::group(['prefix' => 'walls'], function() {
    Route::get('/', [
        'uses' => 'WallsController@index',
        'as' => 'index'
            ]
    );

    Route::get('/create', [
        'uses' => 'WallsController@create',
        'as' => 'create'
            ]
    );

    Route::get('/create/{moduleId}', [
        'uses' => 'WallsController@create',
        'as' => 'create'
            ]
    );

    Route::post('/store', [
        'uses' => 'WallsController@store',
        'as' => 'store'
            ]
    );
    
    Route::get('/show/{wallName}', [
        'uses' => 'WallsController@show',
        'as' => 'show'
            ]
    );
    
    Route::get('/{wallName}/detail', [
        'uses' => 'WallsController@showdetail',
        'as' => 'showdetail'
            ]
    );

    Route::delete('/{wallId}', [
        'uses' => 'WallsController@destroy',
        'as' => 'destroy'
            ]
    );
});

Route::group(['prefix' => 'wizard'], function() {
    Route::get('/', [
        'uses' => 'WizardsController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/course/{viewReturn}', [
        'uses' => 'WizardsController@create',
        'as' => 'create'
            ]
    );

    Route::post('/store', [
        'uses' => 'WizardsController@store',
        'as' => 'store'
            ]
    );
    
    Route::get('/costs', [
        'uses' => 'WizardsController@showCosts',
        'as' => 'showCosts'
            ]
    );
});

Route::group(['prefix' => 'profile'], function() {
    Route::get('/', [
        'uses' => 'UsersController@index',
        'as' => 'index'
            ]
    );

    Route::get('/user/{userId}', [
        'uses' => 'UsersController@index',
        'as' => 'index'
            ]
    );
    
    Route::get('/inscriptions', [
        'uses' => 'UsersController@inscriptions',
        'as' => 'inscriptions'
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

    Route::post('/saveImage', [
        'uses' => 'UsersController@storeImage',
        'as' => 'storeImage'
            ]
    );
});

Route::group(['prefix' => 'results'], function() {
    Route::get('/{type}', [
        'uses' => 'ResultsController@index',
        'as' => 'index'
            ]
    );

    Route::get('/show/{typeExamIdGroupId}', [
        'uses' => 'ResultsController@show',
        'as' => 'show'
            ]
    );
});

Route::group(['prefix' => 'configurations'], function() {
    Route::get('/create', [
        'uses' => 'ConfigurationsController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/create/{viewReturn}', [
        'uses' => 'ConfigurationsController@create',
        'as' => 'create'
            ]
    );
    
    Route::get('/createinscriptions', [
        'uses' => 'ConfigurationsController@createinscriptions',
        'as' => 'createinscriptions'
            ]
    );
    
    Route::get('/createinscriptions/{typeUser}', [
        'uses' => 'ConfigurationsController@createinscriptions',
        'as' => 'createinscriptions'
            ]
    );

    Route::post('/addcolumn', [
        'uses' => 'ConfigurationsController@store',
        'as' => 'store'
            ]
    );

    Route::post('/addcolumn/{continue}', [
        'uses' => 'ConfigurationsController@store',
        'as' => 'store'
            ]
    );
    
    Route::post('/addinscriptions', [
        'uses' => 'ConfigurationsController@storeinscriptions',
        'as' => 'storeinscriptions'
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
