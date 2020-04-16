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

Route::get('/', function () {
    return view('welcome');
})->name('guest-page');


Auth::routes();

// Announcements/Homepage
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/action', 'HomeController@action')->name('home.action');

Route::group(['middleware' => 'auth'], function(){
Route::post('/home', 'HomeController@store')->name('home.store');
Route::get('/announcements/{announcement_id}/edit', 'HomeController@edit')->name('announcement.edit');
Route::patch('/announcements/{announcement_id}', 'HomeController@update')->name('announcement.update');
Route::delete('/announcements/{announcement_id}', 'HomeController@destroy')->name('home.destroy');
});

// About page
Route::get('/about', 'AboutController@index')->name('about');

// D.U.K/F.A.Q page
Route::get('/faq', 'FAQController@index')->name('faq');
Route::post('/faq', 'FAQController@storeQuestion')->name('faq.store.question');
Route::group(['middleware' => 'auth'], function(){
Route::patch('/faq', 'FAQController@storeAnswer')->name('faq.store.answer');
Route::delete('/faq/{faq_id}', 'FAQController@destroyById')->name('faq.destroy');
Route::delete('/faq/{question}', 'FAQController@destroyByQ')->name('q.destroy');
});

Route::get('/kursai','CourseController@index')->name('Kursai');

Route::get('/paskaitos','EventController@index')->name('Paskaitos');
Route::get('/paskaitos/filter','EventController@filter')->name('events.filter');

Route::get('sukurti-paskaita','CreateEventController@index');
Route::post('sukurti-paskaita/fetch', 'CreateEventController@fetch')->name('eventcontroller.fetch');

Route::get('findSteamCenter/{id}','CreateEventController@findSteamCenter');

Route::get('/time','TimeController@index');

Route::group(['prefix' => 'sukurti-kursa', 'middleware' => ['auth' => 'admin']], function(){
    Route::get('/', 'CreateCourseController@index')->name('RouteToCreateCourse');
    Route::post('/','CreateCourseController@insert');
    Route::post('/fetch', 'CreateCourseController@fetch')->name('createcoursecontroller.fetch');
});

Route::group(['prefix' => 'sukurti-paskaita', 'middleware' => ['auth' => 'admin']], function(){
    Route::get('/', 'CreateEventController@index')->name('RouteToCreateEvent');
    Route::post('/','CreateEventController@insert');
    Route::post('/fetch', 'CreateEventController@fetch')->name('createeventcontroller.fetch');
});

Route::group(['prefix' => 'vartotoju-valdymas', 'middleware' => ['auth' => 'admin']], function(){
    Route::get('/', 'UserController@index')->name('RouteToUserManagement');
});


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

// Data insertation page
Route::group(['middleware' => ['auth' => 'admin']], function(){
Route::get('/insertion', 'InsertionController@index')->name('iterpimas');
Route::post('/insertion/fetch', 'InsertionController@fetch')->name('iterpimas.fetch');
Route::post('/insertion/city', 'InsertionController@insertCity')->name('iterpimas.city');
Route::post('/insertion/steam-center', 'InsertionController@insertSteamCenter')->name('iterpimas.steamCenter');
Route::post('/insertion/room', 'InsertionController@insertRoom')->name('iterpimas.room');
});
