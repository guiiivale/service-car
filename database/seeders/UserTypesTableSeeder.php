<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            [
                'title' => 'Company',
                'description' => 'Companies that provide services',
            ],
            [
                'title' => 'Customers',
                'description' => 'Customers that use services',
            ],
        ];

        foreach ($userTypes as $userType) {
            UserType::create($userType);
        }
    }
}
