<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run()
    {
        // Create restaurant tables with different capacities and locations
        $tables = [
            // Small tables (2-4 people)
            ['table_number' => '1', 'capacity' => 2, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '2', 'capacity' => 2, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '3', 'capacity' => 4, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '4', 'capacity' => 4, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '5', 'capacity' => 4, 'location' => 'window seat', 'status' => 'available'],
            ['table_number' => '6', 'capacity' => 4, 'location' => 'window seat', 'status' => 'available'],
            
            // Medium tables (4-6 people)
            ['table_number' => '7', 'capacity' => 6, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '8', 'capacity' => 6, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '9', 'capacity' => 6, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '10', 'capacity' => 6, 'location' => 'bar area', 'status' => 'available'],
            
            // Large tables (8+ people)
            ['table_number' => '11', 'capacity' => 8, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '12', 'capacity' => 8, 'location' => 'indoor', 'status' => 'available'],
            ['table_number' => '13', 'capacity' => 10, 'location' => 'private room', 'status' => 'available'],
            ['table_number' => '14', 'capacity' => 12, 'location' => 'private room', 'status' => 'available'],
            
            // Outdoor tables
            ['table_number' => '15', 'capacity' => 4, 'location' => 'outdoor', 'status' => 'available'],
            ['table_number' => '16', 'capacity' => 4, 'location' => 'outdoor', 'status' => 'available'],
            ['table_number' => '17', 'capacity' => 6, 'location' => 'outdoor', 'status' => 'available'],
            ['table_number' => '18', 'capacity' => 6, 'location' => 'outdoor', 'status' => 'available'],
            ['table_number' => '19', 'capacity' => 8, 'location' => 'outdoor', 'status' => 'available'],
            
            // Bar area tables
            ['table_number' => '20', 'capacity' => 2, 'location' => 'bar area', 'status' => 'available'],
            ['table_number' => '21', 'capacity' => 2, 'location' => 'bar area', 'status' => 'available'],
            ['table_number' => '22', 'capacity' => 4, 'location' => 'bar area', 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            Table::firstOrCreate(
                ['table_number' => $table['table_number']],
                [
                    'capacity' => $table['capacity'],
                    'location' => $table['location'],
                    'status' => $table['status'],
                ]
            );
        }

        // Create some tables with different statuses for realism (only if they don't exist)
        Table::firstOrCreate(
            ['table_number' => '23'],
            [
                'capacity' => 4,
                'location' => 'indoor',
                'status' => 'occupied',
            ]
        );

        Table::firstOrCreate(
            ['table_number' => '24'],
            [
                'capacity' => 6,
                'location' => 'indoor',
                'status' => 'reserved',
            ]
        );

        Table::firstOrCreate(
            ['table_number' => '25'],
            [
                'capacity' => 4,
                'location' => 'indoor',
                'status' => 'maintenance',
            ]
        );
    }
} 