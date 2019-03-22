<?php

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/** @var App\Models\Slider\Slider $slider */
		App\Models\Slider\Slider::create([
			'name' => 'Главная страница',
		]);
	}
}
