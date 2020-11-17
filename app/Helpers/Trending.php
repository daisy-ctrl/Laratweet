<?php
namespace App\Helpers;

use App\Trending as Popular;
use Illuminate\Support\Facades\Cache;

/**
 * Class Trending
 * @package App\Helpers
 */
class Trending
{
    /**
     * @return mixed
     */
    public static function weekly($take = 15)
    {
        $collection = collect();

        $trendings = Cache::remember('popular', 60 * 24, function () {
            return Popular::with('tweet')->weekly()->get();
        });

        $trendings->groupBy('tweet_id')->map(function ($each) use ($collection) {
            $object = collect($each);

            $item = $object->first();
            $item->views = $object->sum('views');

            $collection->push($item);
        });

        return $collection->take($take);
    }
}
