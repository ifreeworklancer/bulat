<?php

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws FileCannotBeAdded
     */
    public function run()
    {
        $faker = Factory::create('ru');

        for ($i = 0; $i < 30; $i++) {
            $data = [
                'ru' => [
                    'title' => ucfirst($faker->words(rand(2, 3), true)),
                    'description' => $faker->sentence(rand(6, 12)),
                    'body' => $faker->sentences(rand(3, 5), true),
                ],
                'uk' => [
                    'title' => ucfirst($faker->words(rand(2, 3), true)),
                    'description' => $faker->sentence(rand(6, 12)),
                    'body' => $faker->sentences(rand(3, 5), true),
                ],
            ];

            $slug = SlugService::createSlug(Product::class, 'slug', $data['uk']['title']);

            /** @var Product $product */
            $product = Product::create([
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

            $product->categories()->attach(Category::inRandomOrder()->take(rand(3, 6))->pluck('id')->all());
        }
    }
}
