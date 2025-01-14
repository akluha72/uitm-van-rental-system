<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Van;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

          // Get valid user and van IDs from the database
          $userIds = User::pluck('id')->toArray(); // Fetch all user IDs
          $vanIds = Van::pluck('id')->toArray();   // Fetch all van IDs

        foreach (range(1, 50) as $index) {
            $startDate = $faker->dateTimeBetween('+1 days', '+30 days');
            $endDate = $faker->dateTimeBetween($startDate, '+30 days'); // Ensures end date is after start date

            DB::table('bookings')->insert([
                'user_id' => $faker->randomElement($userIds), // Pick a random valid user ID
                'van_id' => $faker->randomElement($vanIds),   // Pick a random valid van ID
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_amount' => $faker->randomFloat(2, 100, 1000),
                'amount_due' => $faker->randomFloat(2, 50, 500), // Random due amount
                'amount_paid' => $faker->randomFloat(2, 50, 500), // Random paid amount
                'booking_status' => $faker->randomElement(['pending confirmation', 'confirmed', 'active', 'completed', 'cancelled', 'rejected']),
                'payment_status' => $faker->randomElement(['unpaid', 'paid', 'refunded']),
                'booking_reference' => strtoupper($faker->regexify('[A-Z0-9]{10}')), // Random 10-char alphanumeric
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
