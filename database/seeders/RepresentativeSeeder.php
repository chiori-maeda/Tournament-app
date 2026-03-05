<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RepresentativeSeeder extends Seeder
{
    
    public function run(): void
    {
        $faker = Faker::create('ja_JP');
         for ($i = 0; $i < 20; $i++) {
            DB::table('representatives')->insert([
                'name' => $faker->name,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now()
            ]);
         }
    }
}
