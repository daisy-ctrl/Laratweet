<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\Tweet;
use App\Models\Like;
use Resources\Views;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;


class ProfileController extends Controller
{

  public function __construct()
 {
     $this->middleware('auth');
 }

 public function index()
 {
     return view('layouts.profile');
 }

  public function show($username)
  {
      $user = User::where('username', $username)->firstOrFail();
      $followers_count =  $user->followers()->count();
      $is_edit_profile = false;
      $is_following = false;
        if (Auth::check()) {
          $is_edit_profile = (Auth::id() == $user->id);
          $me = Auth::user();
          $following_count = $is_edit_profile ? $me->following()->count() : 0;
          $is_following = !$is_edit_profile && $me->isFollowing($user);
      }
      return view('profile', [
          'user' => $user,
          'followers_count' => $followers_count,
          'is_edit_profile' => $is_edit_profile,
          'following_count' => $following_count,
          'is_following' => $is_following
          ]);
  }
public function following()
  {
      $me = Auth::user();
      $followers_count = $me->followers()->count();
      $following_count = $me->following()->count();
      $list = $me->following()->orderBy('username')->get();
      $is_edit_profile = true;
      $is_following = false;
       return view('following', [
          'user' => $me,
          'followers_count' => $followers_count,
          'is_edit_profile' => $is_edit_profile,
          'following_count' => $following_count,
          'is_following' => $is_following,
          'list' => $list,
          ]);
  }
public function followers($username)
  {
      $user = User::where('username', $username)->firstOrFail();
      $followers_count =  $user->followers()->count();
      $list = $user->followers()->orderBy('username')->get();
      $is_edit_profile = false;
      $is_following = false;
       if (Auth::check()) {
          $is_edit_profile = (Auth::id() == $user->id);
          $me = Auth::user();
          $following_count = $is_edit_profile ? $me->following()->count() : 0;
          $is_following = !$is_edit_profile && $me->isFollowing($user);
      }
       return view('followers', [
          'user' => $user,
          'followers_count' => $followers_count,
          'is_edit_profile' => $is_edit_profile,
          'following_count' => $following_count,
          'is_following' => $is_following,
          'list' => $list,
          ]);
  }
    public function tweets($user_id)
    {
      $tweet = Tweet::where('user_id', $user_id)->firstOrFail();
      $tweets_count =  $tweet->tweets()->count();
      $list = $tweet->tweets()->orderBy('body')->get();

      $is_edit_profile = false;

      if (Auth::check()) {
          $is_edit_profile = (Auth::id() == $user->id);
          $me = Auth::user();
          $tweets_count = $is_edit_profile ? $me->tweets()->count() : 0;

    }
        return view('tweets', [
        'tweets' => $tweets,
        'tweets_count' => $tweets_count,
        'is_edit_profile' => $is_edit_profile,
        'list' => $list,
        ]);
  }
  public function likes()
  {
      $user = User::where('username', $username)->firstOrFail();
      $me = Auth::user();
      $is_like_button = !$is_edit_profile && !$me->isLiking($tweet);

      return view('profile', ['user' => $user,'is_like_button' => $is_like_button]);
  }

}
