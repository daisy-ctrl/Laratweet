<?php>

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Follower extends Model
{
    use HasFactory, Notifiable;
    /**
    * The tweets that belong to the user.
    */
    public function tweets()
    {
        return $this->belongsToMany('App\Models\Tweet', 'user_id', 'user_id', 'follower_user_id');
    }
}
