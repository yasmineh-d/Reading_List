<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
{
    $path = database_path('seeders/data/books.csv');
    $data = array_map('str_getcsv', file($path));

    $header = array_shift($data);

    foreach ($data as $row) {
        $row = array_combine($header, $row);
        Book::create($row);
    }
}
}