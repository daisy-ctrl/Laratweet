<?php

namespace App\Console\Commands;

use App\Models\Tweet;
use App\Models\Trending;
use Illuminate\Console\Command;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

class TrendingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'analytics:trending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync page view from Google Analytics API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $pages = Analytics::fetchMostVisitedPages(Period::days(1), 300);

      if ($pages->count()) {
          $this->purge();

          $pages->map(function ($each) {
              $each = (object) $each;

              if (starts_with($each->url, '/blog/')) {
                  $slug = str_replace("/blog/", '', $each->url);
                  $tweet = Tweet::findByTitle($slug);

                  if (!empty($blog)) {
                      Trending::create([
                          'tweet_id' => $tweet->id,
                          'views' => $each->pageViews,
                          'body' => $tweet->body,
                          'page_title' => $tweet->user_id,
                          'url' => $each->url,
                      ]);

                      $this->info("{$tweet->body} - {$each->pageViews} \n");
                  }
              }
          });
      }
  }
  /**
     * @return mixed
     */
    public function purge()
    {
        $period = Period::days(8);

        $this->info("Purging records before : {$period->startDate} \n");

        return Trending::where('created_at', '<', $period->startDate)
            ->forceDelete();
    }
}
