<?php

use App\Models\Article\Group;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i = 3; $i; $i--) {
			$data = [
				'uk' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
				'ru' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
				'uk' => ['title' => ucfirst($faker->words(rand(2, 3), true))],
			];

			$slug = SlugService::createSlug(Group::class, 'slug', $data['uk']['title']);

			/** @var \App\Models\Article\Group $group */
			$group = \App\Models\Article\Group::create(['slug' => $slug]);

			collect(config('app.locales'))->each(function ($lang) use ($group, $data) {
				$group->translates()->create([
					'lang' => $lang,
					'title' => $data[$lang]['title'],
				]);
			});
		}
	}
}
