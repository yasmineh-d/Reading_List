<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/users.csv');
        $data = array_map('str_getcsv', file($path));

        $header = array_shift($data);

        foreach ($data as $row) {
            $row = array_combine($header, $row);

            // Using DB to avoid 'hashed' cast if the password is already hashed in CSV
            if (!\App\Models\User::where('email', $row['email'])->exists()) {
                \DB::table('users')->insert($row);
            }
        }
    }
}

