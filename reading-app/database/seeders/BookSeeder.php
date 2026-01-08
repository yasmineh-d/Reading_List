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

            // Handle potential multiple categories (e.g., "Informatique - Histoire")
            $categoryNames = explode(' - ', $row['categories']);
            $primaryCategoryName = trim($categoryNames[0]);

            $category = Category::firstOrCreate(['name' => $primaryCategoryName]);
            $user = User::where('email', $row['user_email'])->firstOrFail();

            Book::firstOrCreate(
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
                    'category_id' => $category->id,
                ]
            );
        }
    }
}
