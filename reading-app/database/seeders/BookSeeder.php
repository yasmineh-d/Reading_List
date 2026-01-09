<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/books.csv');
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        foreach ($data as $row) {
            $row = array_combine($header, $row);

            $user = User::where('email', $row['user_email'])->firstOrFail();

            $book = Book::firstOrCreate(
                [
                    'title' => $row['title'],
                    'user_id' => $user->id
                ],
                [
                    'author' => $row['author'],
                    'publication_date' => $row['publication_date'],
                    'ISBN' => $row['ISBN'],
                    'image' => $row['image'],
                    'description' => $row['description'],
                    'category_id' => 1, // Fallback for the column that still exists
                ]
            );

            // Handle multiple categories
            $categoryNames = explode(' - ', $row['categories']);
            foreach ($categoryNames as $name) {
                $category = Category::firstOrCreate(['name' => trim($name)]);
                $book->categories()->syncWithoutDetaching([$category->id]);
            }
        }
    }
}
