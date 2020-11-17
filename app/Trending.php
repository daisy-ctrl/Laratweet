<?php

namespace App;

use App\Models\Tweet;
use Illuminate\Database\Eloquent\Model;
use Spatie\Analytics\Period;

/**
 * Class Trending
 * @package App
 */
class Trending extends Model
{
    /**
     * @var string
     */
    protected $table = 'trendings';

    /**
     * @var boolean
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected $fillable = ['tweet_id', 'views', 'url', 'page_title'];

    /**
     * @return mixed
     */
    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
    public function scopeTop($query)
   {
       return $query->orderBy('views', 'DESC');
   }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeMonthly($query)
    {
        $period = Period::months(1);

        return $query->whereBetween('created_at', [
            $period->startDate,
            $period->endDate->endOfDay(),
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWeekly($query)
    {
        $period = Period::days(7);

        return $query->whereBetween('created_at', [
            $period->startDate,
            $period->endDate->endOfDay(),
        ]);
    }
    public static function popular($take = 20)
   {
       $collection = collect();
       $trendings = static::weekly()->get();

       $trendings->groupBy('tweet_id')->map(function ($each) use ($collection) {
           $object = collect($each);

           $item = $object->first();
           $item->views = $object->sum('views');

           $collection->push($item);
       });

       return $collection;
   }
}
