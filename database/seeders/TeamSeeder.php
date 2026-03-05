<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ja_JP');
        $classes = [
            '男子A',
            '男子B',
            '男子C',
            '女子AB',
            '女子C'
        ];

        for ( $i = 0; $i < 50; $i++) {
            $teamId = DB::table('teams')->insertGetId([
                'team_name'             => $faker->company . ' 卓球部',
                'class'                 => $faker->randomElement($classes),
                'representative_id'     => rand(1,20), 
                'group_id'              => null,
                'created_at'            => now(),
                'updated_at'            => now()
            ]);

            $memberCount = rand(3,5); //メンバ人数３〜５人
            
            for ($j = 0; $j < $memberCount; $j++) {
                DB::table('team_members')->insert([
                    'team_id'           =>$teamId,
                    'name'              => $faker->name,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        }
    }
    

    
}
