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

$new = 'testpass';
$b->password = Hash::make($new);
$b->save();

echo "Password updated to '{$new}' for baby id {$b->id}\n";

$check = Hash::check($new, $b->password) ? 'MATCH' : 'NO MATCH';
echo "Hash::check('{$new}') => {$check}\n";

$attempt = Auth::guard('baby')->attempt(['mother_email' => $b->mother_email, 'password' => $new]);
echo "Auth::guard('baby')->attempt('{$new}') => " . ($attempt ? 'SUCCESS' : 'FAILED') . "\n";
if ($attempt) Auth::guard('baby')->logout();

return 0;
