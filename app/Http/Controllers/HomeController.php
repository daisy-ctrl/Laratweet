<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Follower;
use App\Models\File;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function posts()
    {
      $tweets = Tweet::get();
      return view('tweets', compact('tweets'));

      $files=File::get();
      return view('files', comact('files'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         return view('home', [
             'user' => Auth::user(),
             ]);
     }
     public function likes($tweet)
     {
         // Find the User. Redirect if the User doesn't exist
         $user = User::where('tweet', $tweet)->firstOrFail();// Find logged in User
         $id = Auth::id();
         $me = User::find($id);
         $me->liking()->attach($user->id);
         return redirect('/' . $tweet);
     }
     public function unlikes($tweet)
     {
         // Find the User. Redirect if the User doesn't exist
         $user = User::where('tweet', $tweet)->firstOrFail();// Find logged in User
         $id = Auth::id();
         $me = User::find($id);
         $me->liking()->detach($user->id);
         return redirect('/' . $tweet);
     }
     public function isLiking($tweet)
     {
         $user = User::where('username', $username)->firstOrFail();
         $me = Auth::user();
         $is_like_button = !$is_edit_profile && !$me->isLiking($tweet);

         return view('profile', ['user' => $user,'is_like_button' => $is_like_button]);
     }

}
