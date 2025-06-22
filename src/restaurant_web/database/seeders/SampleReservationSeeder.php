<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Customer;

class SampleReservationSeeder extends Seeder
{
    public function run()
    {
        // Get customers for creating realistic reservations
        $customers = Customer::all();

        if ($customers->isEmpty()) {
            return; // Skip if no customers exist
        }

        // Create sample reservations for the next 30 days
        for ($i = 0; $i < 20; $i++) {
            $customer = $customers->random();
            $reservationDate = now()->addDays(rand(1, 30));
            $reservationTime = $this->getRandomTime();
            $status = ['pending', 'confirmed', 'cancelled', 'completed'][array_rand(['pending', 'confirmed', 'cancelled', 'completed'])];
            $numGuests = rand(2, 8);

            $reservation = Reservation::create([
                'customer_id' => $customer->id,
                'reservation_date' => $reservationDate->format('Y-m-d'),
                'reservation_time' => $reservationTime,
                'number_of_guests' => $numGuests,
                'status' => $status,
                'special_requests' => rand(0, 1) ? $this->getRandomSpecialRequest() : null,
                'table_number' => rand(1, 25), // Assuming tables 1-25 exist
                'cancellation_reason' => $status === 'cancelled' ? $this->getRandomCancellationReason() : null,
                'confirmed_at' => $status === 'confirmed' ? now()->subHours(rand(1, 24)) : null,
                'cancelled_at' => $status === 'cancelled' ? now()->subHours(rand(1, 12)) : null,
            ]);
        }

        // Create some reservations for today and tomorrow
        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');

        // Today's reservations
        for ($i = 0; $i < 3; $i++) {
            $customer = $customers->random();
            Reservation::create([
                'customer_id' => $customer->id,
                'reservation_date' => $today,
                'reservation_time' => $this->getRandomTime(),
                'number_of_guests' => rand(2, 6),
                'status' => 'confirmed',
                'special_requests' => rand(0, 1) ? 'Window seat preferred' : null,
                'table_number' => rand(1, 25),
                'confirmed_at' => now()->subHours(rand(1, 6)),
            ]);
        }

        // Tomorrow's reservations
        for ($i = 0; $i < 5; $i++) {
            $customer = $customers->random();
            Reservation::create([
                'customer_id' => $customer->id,
                'reservation_date' => $tomorrow,
                'reservation_time' => $this->getRandomTime(),
                'number_of_guests' => rand(2, 8),
                'status' => 'confirmed',
                'special_requests' => rand(0, 1) ? 'Birthday celebration' : null,
                'table_number' => rand(1, 25),
                'confirmed_at' => now()->subHours(rand(1, 12)),
            ]);
        }
    }

    private function getRandomTime()
    {
        $hours = [11, 12, 13, 17, 18, 19, 20, 21]; // Restaurant hours
        $hour = $hours[array_rand($hours)];
        $minute = rand(0, 3) * 15; // 15-minute intervals
        return sprintf('%02d:%02d:00', $hour, $minute);
    }

    private function getRandomSpecialRequest()
    {
        $requests = [
            'Window seat preferred',
            'Quiet table please',
            'High chair needed',
            'Wheelchair accessible table',
            'Birthday celebration',
            'Anniversary celebration',
            'Business meeting',
            'Extra napkins please',
        ];
        return $requests[array_rand($requests)];
    }

    private function getRandomCancellationReason()
    {
        $reasons = [
            'Change of plans',
            'Weather conditions',
            'Personal emergency',
            'Found alternative restaurant',
            'Group size changed',
            'Time conflict',
        ];
        return $reasons[array_rand($reasons)];
    }
} 