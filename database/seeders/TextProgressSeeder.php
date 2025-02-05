<?php

namespace Database\Seeders;

use App\Models\TextProgress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TextProgressSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run() : void
	{
		TextProgress::factory( 5 )->create();
	}
}
