<?php

namespace App\Models;

use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Tweet extends Model
{
  use Taggable,HasFactory;

  protected $fillable = [
      'user_id', 'body', 'slug'
  ];

  public function link()
  {
      return $this->belongsTo('App\Models\Link', 'link_id');
  }
  public function getCreatedAtAttribute($value)
  {
    return Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
  }
  public function author()
  {
    return $this->belongsTo('App\Models\User', 'user_id');
  }
  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }
  public function tags()
  {
    return $this->belongsToMany('App\Models\Tag');
  }
  public static function findByTitle($slug = null)
  {
      return self::where('slug', $slug)->first();
  }
  public function likes()
  {
    return $this->hasMany(Likes::class, 'tweet_id', 'id');
  }
}
