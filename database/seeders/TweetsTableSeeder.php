<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tweet;
use Database\Seeders\factory;
use Database\Factories\ModelFactory;

class TweetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tweet::factory()->count(100)->create([
            'user_id' => 1
          ]);
    }
}
