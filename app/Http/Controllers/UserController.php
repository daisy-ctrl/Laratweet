<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\Follower;

class UserController extends Controller
{
    public function follows(Request $request)
  {
    $username =  $request->input('username');
    // Find the User. Redirect if the User doesn't exist
    try {
      $user = User::where('username', $username)->firstOrFail();
    } catch (ModelNotFoundException $exp) {
      return $this->responseFail('User doesn\'t exists');
    }
    // Find logged in User
    $id = Auth::id();
    $me = User::find($id);
    $me->following()->attach($user->id);
    return $this->responseSuccess();
  }

  public function unfollows(Request $request)
  {
    $username =  $request->input('username');
    // Find the User. Redirect if the User doesn't exist
    try {
      $user = User::where('username', $username)->firstOrFail();
    } catch (ModelNotFoundException $exp) {
        return $this->responseFail('User doesn\'t exists');
   }
    // Find logged in User
    $id = Auth::id();
    $me = User::find($id);
    $me->following()->detach($user->id);
    return $this->responseSuccess();
  }
  private function responseSuccess($message = '')
  {
     return $this->response(true, $message);
   }
   private function responseFail($message = '')
   {
     return $this->response(false, $message);
   }
   private function response($status = false, $message = '')
   {
     return response()->json([
          'status' => $status,
          'message' => $message,
          ]);
    }

}
