<?php

namespace Database\Factories;

use App\Models\Text;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TextProgress>
 */
class TextProgressFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition() : array
	{
		return [
			'user_id' => User::query()->inRandomOrder()->first()->id,
			'text_id' => Text::query()->inRandomOrder()->first()->id,
			'words_per_minute' => fake()->numberBetween( 10, 40 ),
			'symbols_per_minute' => fake()->numberBetween( 50, 100 ),
		];
	}
}
