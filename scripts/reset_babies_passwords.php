<?php
// Usage (local only):
// php reset_babies_passwords.php sanu@gmail.com=testpass,has@gmail.com=password123
// or to reset one: php reset_babies_passwords.php sanu@gmail.com=testpass
// This script only runs when app()->environment('local') to avoid accidental production changes.

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if (! app()->environment('local')) {
    echo "This script can only be run in local environment.\n";
    exit(1);
}

use App\Models\Baby;
use Illuminate\Support\Facades\Hash;

if ($argc < 2) {
    echo "Provide comma-separated email=password pairs as the first argument.\n";
    exit(1);
}

$pairs = explode(',', $argv[1]);
foreach ($pairs as $pair) {
    [$email, $password] = explode('=', $pair) + [null, null];
    $email = trim($email);
    $password = trim($password);
    if (! $email || ! $password) {
        echo "Invalid pair: $pair\n";
        continue;
    }

    $baby = Baby::where('mother_email', $email)->first();
    if (! $baby) {
        echo "Baby not found for email: $email\n";
        continue;
    }

    $baby->password = Hash::make($password);
    $baby->save();
    echo "Updated password for {$email}\n";
}
