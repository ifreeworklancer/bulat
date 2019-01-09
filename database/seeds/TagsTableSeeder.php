<?php

use App\Models\Article\Tag;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (\App\Models\Article\Group::get() as $group) {
			for ($i = rand(3, 6); $i; $i--) {
				$data = [
					'ru' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
					'en' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
				];

				$slug = SlugService::createSlug(Tag::class, 'slug', $data['en']['title']);
				$tag = Tag::create(['slug' => $slug, 'group_id' => $group->id]);

				collect(config('app.locales'))->each(function ($lang) use ($tag, $data) {
					$tag->translates()->create([
						'lang' => $lang,
						'title' => $data[$lang]['title'],
					]);
				});
			}
		}
	}
}
