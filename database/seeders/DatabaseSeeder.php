<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
   
    public function run(): void
    {
        $this->call([
            RepresentativeSeeder::class,
            TeamSeeder::class,
        ]);
    }
}
