<?php
namespace App;

trait LikeableTrait
{
  public function likes()
  {
    return $this->morphMany(Like::class, 'likeable');
  }
  public function likeIt()
  {
    $like=new Like();
    $like->user_id=auth()->user()->id;

    $this->likes()->save($like);

    return $like;
  }
}
