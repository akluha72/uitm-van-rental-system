<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('bookings')->insert([
                'user_id' => $faker->numberBetween(1, 10), // Assuming 10 users exist
                'van_id' => $faker->numberBetween(1, 20), // Assuming 20 vans exist
                'start_date' => $faker->dateTimeBetween('+1 days', '+30 days'),
                'end_date' => $faker->dateTimeBetween('+31 days', '+60 days'),
                'total_amount' => $faker->randomFloat(2, 100, 1000),
                'booking_status' => $faker->randomElement(['pending', 'confirmed', 'cancelled']),
                'payment_status' => $faker->randomElement(['unpaid', 'paid', 'refunded']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
