<?php
// Simple bootstrap script to inspect the first Baby record and attempt authentication
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Baby;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$b = Baby::first();
if (! $b) {
    echo "No baby records found\n";
    exit(1);
}

echo "Baby ID: {$b->id}\n";
echo "Mother email: {$b->mother_email}\n";
echo "Password hash: {$b->password}\n";

$pwToTry = 'user123';
$check = Hash::check($pwToTry, $b->password) ? 'MATCH' : 'NO MATCH';
echo "Hash::check('{$pwToTry}') => {$check}\n";

$attempt = Auth::guard('baby')->attempt(['mother_email' => $b->mother_email, 'password' => $pwToTry]);
echo "Auth::guard('baby')->attempt('{$pwToTry}') => " . ($attempt ? 'SUCCESS' : 'FAILED') . "\n";

auth_print:
echo "Auth guard baby check: " . (Auth::guard('baby')->check() ? 'LOGGED IN' : 'NOT LOGGED IN') . "\n";

// If failed, try with an empty password to show behavior
$attempt2 = Auth::guard('baby')->attempt(['mother_email' => $b->mother_email, 'password' => 'wrongpassword']);
echo "Auth::guard('baby')->attempt('wrongpassword') => " . ($attempt2 ? 'SUCCESS' : 'FAILED') . "\n";

return 0;
