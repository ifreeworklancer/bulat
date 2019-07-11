<?php

use App\Models\Article\Article;
use App\Models\Article\Tag;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i = 10; $i; $i--) {
			$data = [
                'uk' => [
                    'title' => ucfirst($faker->words(rand(3, 8), true)),
                    'body' => '<p>' . implode('</p><p>', $faker->sentences(rand(10, 15))) . '</p>',
                ],
				'ru' => [
					'title' => ucfirst($faker->words(rand(3, 8), true)),
					'body' => '<p>' . implode('</p><p>', $faker->sentences(rand(10, 15))) . '</p>',
				],
				'uk' => [
					'title' => ucfirst($faker->words(rand(3, 8), true)),
					'body' => '<p>' . implode('</p><p>', $faker->sentences(rand(10, 15))) . '</p>',
				],
			];

			$slug = SlugService::createSlug(Article::class, 'slug', $data['uk']['title']);

			/** @var Article $article */
			$article = Article::create([
				'slug' => $slug,
				'is_published' => 1,
			]);

			collect(config('app.locales'))->each(function ($lang) use ($article, $data) {
				$article->translates()->create([
					'lang' => $lang,
					'title' => $data[$lang]['title'],
					'body' => $data[$lang]['body'],
				]);
			});

			$article->tags()->attach(Tag::inRandomOrder()->take(rand(3, 6))->pluck('id')->all());
		}
	}
}
