<?php
namespace App\Http\Controllers;

use App\Helpers\Trending;
use App\Models\Trending;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

class TrendingController extends Controller{
    public function show()
    {
        $trendings = Analytics::fetchMostVisitedPages(
            Period::days(7),
            15
        );
        $trendings = Trending::weekly();

        return view('trending', compact('trendings'));
    }
}
