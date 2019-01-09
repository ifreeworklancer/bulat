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
		$faker = \Faker\Factory::create();

		factory(\App\Models\User\User::class)->create(['email' => 'admin@app.com', 'role_id' => 1]);
		factory(\App\Models\User\User::class, 10)->create();

		foreach (\App\Models\User\User::get() as $user) {
			if (rand(0, 1)) {
				$user->profile()->create([
					'phone_1' => $faker->e164PhoneNumber,
					'phone_2' => rand(0, 1) ? $faker->e164PhoneNumber : null,
					'country' => $faker->country,
					'city' => $faker->city,
					'address' => rand(0, 1) ? $faker->address : null,
				]);
			}
		}
	}
}
