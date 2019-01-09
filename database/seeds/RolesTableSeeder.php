<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		collect(\App\Models\User\Role::$ROLES)->each(function ($role) {
			\App\Models\User\Role::create(['name' => $role]);
		});
	}
}
