<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [ 'as' => 'loginForm', 'uses' => 'Auth\AuthController@getLogin' ]);
Route::post('/login', [ 'as' => 'loginSend', 'uses' => 'Auth\AuthController@postLogin' ]);

Route::get('/tijdschema', function () {
    return view('tijdschema');
});

Route::get('/competitie', function () {
    return view('competitie');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/ticketgenerator', function () {
    return view('ticketgenrator');
});

Route::post('/registratie', function () {
    return view("registratie");
});

Route::get('/registratie', function () {
    return view("registratie");
});

Route::get('/tickets', function () {
    return view("tickets");
});

Route::post('/tickets', function () {
    return view("tickets");
});

Route::post('/functions', function () {
    return view("functions");
});

Route::get('/confirm', function () {
    return view("confirm");
});

Route::post('/confirm', function () {
    return view("confirm");
});

Route::post('/teams', function () {
    return view("teams");
});

Route::get('/teams', function () {
    return view("teams");
});

Route::post('/teams2', function () {
    return view("teams2");
});

Route::get('/teams2', function () {
    return view("teams2");
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
