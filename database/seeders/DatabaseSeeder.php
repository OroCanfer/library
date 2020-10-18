<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create();

    	foreach (range(1,500) as $index) {
            DB::table('users')->insert([
                'name' => $faker->firstname,
                'password' => $faker->password,
                'email' => $faker->email,
                'created_at' => Carbon::now()
            ]);
        }
        // \App\Models\User::factory(10)->create();
    }
}
