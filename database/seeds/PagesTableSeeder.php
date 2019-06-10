<?php

use App\Models\Additional\Page;
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
            'warranty'
        ];

        foreach ($pages as $slug) {
            /** @var Page $page */
            $page = Page::firstOrCreate([
                'slug' => $slug,
            ]);

            foreach (config('app.locales') as $lang) {
                $page->translates()->updateOrCreate([
                    'lang' => $lang,
                    'title' => trans('pages.'.$slug.'.title'),
                ]);
            }
        }
    }
}
