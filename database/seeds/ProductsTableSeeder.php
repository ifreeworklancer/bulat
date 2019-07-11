<?php

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
	 */
	public function run()
	{
		$faker = \Faker\Factory::create('ru');

		for ($i = 0; $i < 30; $i++) {
			$data = [
                'uk' => [
                    'title' => ucfirst($faker->words(rand(2, 3), true)),
                    'description' => $faker->sentence(rand(6, 12)),
                    'body' => $faker->sentences(rand(3, 5), true),
                ],
				'ru' => [
					'title' => ucfirst($faker->words(rand(2, 3), true)),
					'description' => $faker->sentence(rand(6, 12)),
					'body' => $faker->sentences(rand(3, 5), true),
				],
				'en' => [
					'title' => ucfirst($faker->words(rand(2, 3), true)),
					'description' => $faker->sentence(rand(6, 12)),
					'body' => $faker->sentences(rand(3, 5), true),
				],
			];

			$slug = SlugService::createSlug(\App\Models\Catalog\Product::class, 'slug', $data['en']['title']);

			/** @var \App\Models\Catalog\Product $product */
			$product = \App\Models\Catalog\Product::create([
				'slug' => $slug,
				'price' => rand(500, 1500),
			]);

			foreach (config('app.locales') as $lang) {
				$product->translates()->create([
					'lang' => $lang,
					'title' => $data[$lang]['title'],
					'description' => $data[$lang]['description'],
					'body' => $data[$lang]['body'],
				]);
			}

			$product->categories()->attach(\App\Models\Catalog\Category::inRandomOrder()->take(rand(3, 6))->pluck('id')->all());

			$product->clearMediaCollection('products');
			for ($img = rand(2, 4); $img; $img--) {
				$product->addMediaFromUrl($faker->imageUrl(1920, 1080))
						->toMediaCollection('products');
			}
		}
	}
}
