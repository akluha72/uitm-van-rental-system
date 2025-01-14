<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;


class VanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('vans')->insert([
                'model' => $faker->word,
                'capacity' => $faker->numberBetween(4, 15),
                'rental_rate' => $faker->randomFloat(2, 50, 300),
                'license_plate' => strtoupper(Str::random(7)),
                'availability' => $faker->boolean(80), // 80% chance the van is available
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
