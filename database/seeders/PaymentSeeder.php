<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('payments')->insert([
                'booking_id' => $faker->numberBetween(1, 50), // Assuming 50 bookings exist
                'payment_date' => $faker->dateTimeBetween('-30 days', 'now'),
                'amount_paid' => $faker->randomFloat(2, 50, 1000),
                'payment_method' => $faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
                'payment_status' => $faker->randomElement(['pending', 'completed', 'failed']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
