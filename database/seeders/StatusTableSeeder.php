<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Scheduled',
                'description' => 'The appointment is scheduled but has not started yet.',
            ],
            [
                'name' => 'In progress',
                'description' => 'The appointment is in progress.',
            ],
            [
                'name' => 'Completed',
                'description' => 'The appointment has been completed.',
            ],
            [
                'name' => 'Canceled',
                'description' => 'The appointment has been canceled.',
            ],
        ];

        foreach ($statuses as $status) {
            DB::table('status')->insert($status);
        }
    }
}
