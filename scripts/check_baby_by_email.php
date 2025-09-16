<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Baby;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$email = 'sanu@gmail.com';
$b = Baby::where('mother_email', $email)->first();
if (! $b) {
    echo "No baby found for {$email}\n";
    exit(1);
}

echo "Baby ID: {$b->id}\n";
echo "Mother email: {$b->mother_email}\n";
echo "Password hash: {$b->password}\n";

$passwords = ['user123', 'password', '123456', 'admin123', ''];
foreach ($passwords as $pw) {
    $check = Hash::check($pw, $b->password) ? 'MATCH' : 'NO MATCH';
    echo "Hash::check('{$pw}') => {$check}\n";
    $attempt = Auth::guard('baby')->attempt(['mother_email' => $b->mother_email, 'password' => $pw]);
    echo "Auth::guard('baby')->attempt('{$pw}') => " . ($attempt ? 'SUCCESS' : 'FAILED') . "\n";
    if ($attempt) {
        Auth::guard('baby')->logout();
    }
}

// Show last updated time
echo "Updated at: {$b->updated_at}\n";
return 0;
