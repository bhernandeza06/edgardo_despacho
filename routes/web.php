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
Route::get('doc/{instance_id}/{title}/{link}/save', 'DocumentController@save');

Route::group(['middleware' => 'auth'], function()
{
  Route::resource('customer', 'CustomerController');
  Route::get('customer/{query}/showByQuery', 'CustomerController@showByQuery');

  Route::get('concrete/{instance_id}/get', 'ConcreteActionController@get');
  Route::get('concrete/{instance_id}/{action}/{reminder}/save', 'ConcreteActionController@save');
  Route::get('concrete/{action_id}/destroy', 'ConcreteActionController@destroy');

  Route::get('reminder/{instance_id}/get', 'ReminderController@get');
  Route::get('reminder/{instance_id}/{reminder}/{reminder_date}/save', 'ReminderController@save');
  Route::get('reminder/{reminder_id}/destroy', 'ReminderController@destroy');

  Route::get('cost/{instance_id}/get', 'CostController@get');
  Route::get('cost/{instance_id}/{subject}/{amount}/save', 'CostController@save');
  Route::get('cost/{cost_id}/destroy', 'CostController@destroy');

  Route::get('doc/{instance_id}/get', 'DocumentController@get');
  Route::get('doc/{doc_id}/destroy', 'DocumentController@destroy');

  Route::get('reminders_by_date/{date}/showByDate', 'ReminderController@showByDate');
  Route::get('actions_by_date/{date}/showByDate', 'ConcreteActionController@showByDate');

  Route::view('/actions', 'actions');

  Route::resource('instance', 'InstanceController');
  Route::get('instance/{query}/create_with_user', 'InstanceController@create_with_user')->middleware('auth');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
