<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class ShowTimeline extends Controller
{
  public function __invoke()
  {
      $user = Auth::user();

      return response()->json($user->timeline());
  }
  public function liking(request $request)
  {
      $user = User::where('username', $username)->firstOrFail();
      $me = Auth::user();
      $is_like_button = !$is_edit_profile && !$me->isLiking($tweet);

      return view('profile', ['user' => $user,'is_like_button' => $is_like_button]);
  }
}
