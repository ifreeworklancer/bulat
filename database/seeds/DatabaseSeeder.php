<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([
			RolesTableSeeder::class,
			UsersTableSeeder::class,
			PagesTableSeeder::class,
			SlidersTableSeeder::class,
			CategoriesTableSeeder::class,
			ProductsTableSeeder::class,
			GroupsTableSeeder::class,
			TagsTableSeeder::class,
			ArticlesTableSeeder::class,
		]);
	}
}
