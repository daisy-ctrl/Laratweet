<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\PostTweet;
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
    broadcast(new WebSocketDemoEvent('some data'));

    return view('welcome');
});
Route::get('/chats', 'App\Http\Controllers\ChatsController@index');
Route::get('/messages', 'App\Http\Controllers\ChatsController@fetchMessage');
Route::get('/messages', 'App\Http\Controllers\ChatsController@sendMessage');
Route::get('/uploadfile', 'App\Http\Controllers\UploadfileController@index');
Route::post('/uploadfile', 'App\Http\Controllers\UploadfileController@upload');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/home', 'chat');
Route::resource('messages', 'App\Http\Controllers\MessageController')->only([
    'index',
    'store'
]);
Route::get('/{username}', 'App\Http\Controllers\ProfileController@show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/timeline', 'App\Http\Controllers\ShowTimeline');
    Route::post('/tweet', 'App\Http\Controllers\PostTweet');
    Route::post('/likes-tweet/{tweet_id}', 'App\Http\Controllers\ProfileController@LikeTweet');
    Route::get('/following', 'App\Http\Controllers\ProfileController@following')->name('following');
    Route::post('/follows', 'App\Http\Controllers\UserController@follows');
    Route::post('/unfollows', 'App\Http\Controllers\UserController@unfollows');
    Route::get('/delete-tweet/{tweet_id}','App\Http\Controllers\PostTweet@getDeleteTweet')->name('tweet.delete');

    Route::post('/follows', 'App\Http\Controllers\HomeController@follows');
    Route::post('/unfollows', 'App\Http\Controllers\HomeController@unfollows');
});

Route::get('/{username}', 'App\Http\Controllers\ProfileController@show')->name('profile');
Route::get('/{username}/followers', 'App\Http\Controllers\ProfileController@followers')->name('followers');
Route::get('{username}/following', 'App\Http\Controllers\ProfileController@following')->name('following');

Route::get ( '/', function () {
    return view ( 'welcome' );
} );

Route::any('/search',function(){
    $q = Request::get ( 'q' );
    $user = User::where('username','LIKE','%'.$q.'%')->orWhere('username','LIKE','%'.$q.'%')->get();
    if(count($user) > 0)
        return view('welcome')->withDetails($user)->withQuery ( $q );
    else
      return view ('welcome')->withMessage('No Details found. Try to search again !');

  });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
