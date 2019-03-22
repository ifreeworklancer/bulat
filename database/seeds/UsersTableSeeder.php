<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		factory(\App\Models\User\User::class)->create([
			'email' => 'admin@app.com',
			'role_id' => 1,
		]);
	}
}
