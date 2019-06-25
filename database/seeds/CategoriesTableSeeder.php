<?php

use App\Models\Catalog\Category;
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
                'ru' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
                'uk' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
            ];

            $slug = SlugService::createSlug(Category::class, 'slug', $data['ru']['title']);

            $category = Category::create(['slug' => $slug]);

            collect(config('app.locales'))->each(function ($lang) use ($category, $data) {
                $category->translates()->create([
                    'lang' => $lang,
                    'title' => $data[$lang]['title'],
                ]);
            });
        }
    }
}
