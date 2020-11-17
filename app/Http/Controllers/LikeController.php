<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
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
