<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'tweet_id'
    ];
    public function getCreatedAtAttribute($value)
    {
      return Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }
    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

}
