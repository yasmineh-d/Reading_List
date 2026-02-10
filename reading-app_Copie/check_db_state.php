<?php

use App\Models\User;
use App\Models\Category;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Users count: " . User::count() . "\n";
if (User::count() > 0) {
    echo "First User ID: " . User::first()->id . "\n";
} else {
    echo "No users found.\n";
}

echo "Categories count: " . Category::count() . "\n";
if (Category::count() > 0) {
    echo "Categories: " . Category::pluck('name')->implode(', ') . "\n";
} else {
    echo "No categories found.\n";
}
