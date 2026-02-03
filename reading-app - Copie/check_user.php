<?php
use App\Models\User;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$user = User::find(1);
if ($user) {
    echo "User 1 Exists: " . $user->name . "\n";
} else {
    echo "User 1 Missing. Creating...\n";
    $user = User::create([
        'id' => 1,
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    echo "User 1 Created.\n";
}