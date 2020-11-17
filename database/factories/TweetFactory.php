<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TweetFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = \App\Models\Tweet::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
    public function definition()
    {
      return [
          'body' => $this->faker->realText(140),
      ];
    }
}
