<?php

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker\Factory::create();

		for ($i = 6; $i; $i--) {
			$data = [
			    'uk' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
				'ru' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
				'en' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
			];

			$slug = SlugService::createSlug(\App\Models\Catalog\Category::class, 'slug', $data['en']['title']);

			$category = \App\Models\Catalog\Category::create(['slug' => $slug]);

			collect(config('app.locales'))->each(function ($lang) use ($category, $data) {
				$category->translates()->create([
					'lang' => $lang,
					'title' => $data[$lang]['title'],
				]);
			});

			$category->addMediaFromUrl($faker->imageUrl(1280, 768))->toMediaCollection('category');
		}
    }
}
