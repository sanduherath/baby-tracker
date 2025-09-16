<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Baby;

$babies = Baby::all();
foreach ($babies as $b) {
    echo "ID: {$b->id} | email: {$b->mother_email} | updated_at: {$b->updated_at}\n";
}
