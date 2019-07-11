<?php

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'email' => 'r_kosarev@ukr.net',
            'password' => Hash::make('Rom20100000Kos'),
            'role_id' => 1,
        ]);
    }
}
