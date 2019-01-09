<?php

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
	 */
	public function run()
	{
		$faker = \Faker\Factory::create();

		/** @var App\Models\Slider\Slider $slider */
		$slider = App\Models\Slider\Slider::create([
			'name' => 'Главная страница',
		]);

		foreach (range(1, 4) as $item) {
			/** @var \App\Models\Slider\Slide $slide */
			$slide = $slider->slides()->create();

			foreach (config('app.locales') as $lang) {
				$slide->translates()->create([
					'lang' => $lang,
					'title' => ucfirst($faker->words(rand(3, 6), true)),
					'description' => $faker->sentence(rand(10, 20)),
				]);
			}

			$slide->addMediaFromUrl($faker->imageUrl(1920, 1080))->toMediaCollection('slides');
		}
	}
}
