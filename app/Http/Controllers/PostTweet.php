<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Tweet;
use App\Http\Requests\PostTweetRequest;
use App\Models\Link;
use App\Http\Controllers\PostTweet;
use Illuminate\Support\Facades\Validator;

class PostTweet extends Controller
{
  public function __invoke(PostTweetRequest $request)
  {
      $tweet = new Tweet(['body' => $request->tweet_body]);
      Auth::user()->tweets()->save($tweet);

      $this->detectLink($tweet->fresh());

      return redirect('home');

  }
  private function detectLink(Tweet $tweet)
  {
      $reg_exLink = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
      // Check if there is a url in the text
      if(preg_match($reg_exLink, $tweet->body, $url)) {
          $link = Link::firstOrCreate(['url' => $url[0]]);
          $tweet->link_id = $link->id;
          $tweet->save();
      }
    }
  public function getDeleteTweet($tweet_id)
  {
      $tweet = Tweet::where('id', $tweet_id)->first();
      $tweet->delete();
      return redirect('home')->with(['message' => 'Successfully deleted!']);
    }

    public function index()
 {
     return view('home');
 }

 public function tweet()
 {
     $tweet = Tweet::get();
     return view('tweet', compact('tweet'));
 }


}
