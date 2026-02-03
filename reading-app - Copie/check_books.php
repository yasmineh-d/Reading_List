<?php
use App\Models\Book;
use Illuminate\Support\Facades\Log;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$count = Book::count();
echo "Total Books: " . $count . "\n";

$lastBook = Book::orderBy('created_at', 'desc')->first();
if ($lastBook) {
    echo "Last Book: " . $lastBook->title . " (ID: " . $lastBook->id . ") created at " . $lastBook->created_at . "\n";
} else {
    echo "No books found.\n";
}
