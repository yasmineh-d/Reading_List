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
        if (($handle = fopen(database_path('seeders/data/books.csv'), 'r')) !== false) {
            $header = fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                // Find user
                $user = User::where('email', $data['user_email'])->first();
                if (!$user) {
                    continue;
                }

                // Create book
                $book = Book::create([
                    'title' => $data['title'],
                    'author' => $data['author'],
                    'publication_date' => $data['publication_date'],
                    'ISBN' => $data['ISBN'],
                    'image' => $data['image'],
                    'description' => $data['description'],
                    'user_id' => $user->id,
                ]);

                // Attach categories (many-to-many) - Using " - " as delimiter from books.csv
                $categoryNames = explode(' - ', $data['categories']);
                $categoryIds = [];

                foreach ($categoryNames as $name) {
                    $category = Category::firstOrCreate(['name' => trim($name)]);
                    $categoryIds[] = $category->id;
                }

                $book->categories()->attach($categoryIds);
            }

            fclose($handle);
        }
    }
}
