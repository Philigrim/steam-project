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

Route::group(['prefix' => 'paskaitos'], function(){
    Route::get('/','EventController@index')->name('Paskaitos');
    Route::get('/filter', 'EventController@filter')->name('events.filter');
    Route::post('/','EventController@insert')->name('eventcontroller.insert');
    Route::post('/fetch_lecturers','EventController@fetch_lecturers')->name('eventcontroller.fetch_lecturers');
});

Route::group(['prefix' => 'sukurti-kursa', 'middleware' => ['auth' => 'admin']], function(){
    Route::get('/', 'CreateCourseController@index')->name('RouteToCreateCourse');
    Route::post('/','CreateCourseController@insert');
});

Route::group(['prefix' => 'sukurti-paskaita', 'middleware' => ['paskaitu_lektorius']], function(){
    Route::get('/', 'CreateEventController@index')->name('RouteToCreateEvent');
    Route::post('/','CreateEventController@insert');
    Route::post('/fetch_lecturers', 'CreateEventController@fetch_lecturers')->name('createeventcontroller.fetch_lecturers');
    Route::post('/fetch', 'CreateEventController@fetch')->name('createeventcontroller.fetch');
    Route::post('/fetch_time', 'CreateEventController@fetch_time')->name('createeventcontroller.fetch_time');
});

Route::group(['prefix' => 'vartotoju-valdymas', 'middleware' => ['auth' => 'admin']], function(){
    Route::get('/', 'UserController@index')->name('RouteToUserManagement');
});


Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController', ['except' => ['show']]);
    // Route::get('profile',['as' => 'profile.index','uses'=> 'ProfileController@index']);
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
