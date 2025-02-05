<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Text>
 */
class TextFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition() : array
	{
		return [
			'title' => fake( 'ru_RU' )->realText( fake()->numberBetween( 10, 50 ) ),
			'text' => fake( 'ru_RU' )->realText( fake()->numberBetween( 50, 200 ) ),
			'user_id' => fake()->randomElement( [User::query()->inRandomOrder()->first()->id, null] ),
		];
	}
}
