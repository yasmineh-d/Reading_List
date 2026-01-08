<?php

use App\Services\CategoryService;
use App\Services\UserService;
use App\Models\User;
use App\Models\Category;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing UserService...\n";
$userService = app(UserService::class);

// Create
$user = $userService->create([
    'username' => 'service_test',
    'email' => 'service@test.com',
    'password' => 'password'
]);
echo "Created User ID: " . $user->id . "\n";

// GetById
$retrievedUser = $userService->getById($user->id);
echo "Retrieved User: " . $retrievedUser->username . "\n";

// Update
$updatedUser = $userService->update($user->id, ['username' => 'service_updated']);
echo "Updated User: " . $updatedUser->username . "\n";

// Delete
$userService->delete($user->id);
echo "User Deleted. Exists? " . (User::find($user->id) ? 'Yes' : 'No') . "\n";


echo "\nTesting CategoryService...\n";
$catService = app(CategoryService::class);

// Create (already existed, but good to test)
$cat = $catService->create(['name' => 'Test Category']);
echo "Created Category ID: " . $cat->id . "\n";

// GetById (added)
$retrievedCat = $catService->getById($cat->id);
echo "Retrieved Category: " . $retrievedCat->name . "\n";

// Update (added)
$updatedCat = $catService->update($cat->id, ['name' => 'Updated Category']);
echo "Updated Category: " . $updatedCat->name . "\n";

// Delete (already existed)
$catService->delete($cat->id);
echo "Category Deleted. Exists? " . (Category::find($cat->id) ? 'Yes' : 'No') . "\n";
