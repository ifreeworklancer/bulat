<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$pages = [
			'about',
			'articles',
			'contacts',
			'catalog',
			'terms-and-conditions',
		];

		foreach ($pages as $slug) {
			/** @var \App\Models\Additional\Page $page */
			$page = \App\Models\Additional\Page::create([
				'slug' => $slug,
			]);

			foreach (config('app.locales') as $lang) {
				app()->setLocale($lang);
				$page->translates()->create([
					'lang' => $lang,
					'title' => trans('pages.' . $slug . '.title'),
				]);
			}
		}
	}
}
