<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\LinkCreated;

class Link extends Model
{
    use HasFactory;

    /**
    * The event map for the model.
    *
    * @var array
    */
    protected $events = [
        'created' => LinkCreated::class,
    ];

    protected $fillable = [
        'url', 'cover', 'title', 'description',
    ];

    public function tweets()
    {
        return $this->hasMany('App\Models\Tweet', 'link_id');
    }

}
