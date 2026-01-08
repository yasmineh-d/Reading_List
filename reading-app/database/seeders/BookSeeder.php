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

            $category = Category::where('name', $row['categories'])->firstOrFail();
            $user = User::where('email', $row['user_email'])->firstOrFail();

            Book::create([
                'title' => $row['title'],
                'author' => $row['author'],
                'publication_date' => $row['publication_date'],
                'ISBN' => $row['ISBN'],
                'image' => $row['image'],
                'description' => $row['description'],
                'category_id' => $category->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
