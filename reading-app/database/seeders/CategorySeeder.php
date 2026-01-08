<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/categories.csv');
        $data = array_map('str_getcsv', file($path));

        $header = array_shift($data);

        foreach ($data as $row) {
            $row = array_combine($header, $row);
            Category::firstOrCreate(
                ['name' => $row['name']],
                $row
            );
        }
    }
}
