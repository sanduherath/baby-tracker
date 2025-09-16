<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

echo "SESSION_DRIVER = " . Config::get('session.driver') . "\n";
echo "SESSION_COOKIE = " . Config::get('session.cookie') . "\n";
echo "SESSION_TABLE = " . Config::get('session.table') . "\n";

try {
    $exists = DB::select("SELECT 1 FROM information_schema.tables WHERE table_name = 'sessions'");
    if (!empty($exists)) {
        $count = DB::table('sessions')->count();
        echo "sessions table exists. rows: $count\n";
    } else {
        echo "sessions table does NOT appear in information_schema (may be sqlite or different DB).\n";
        // try SQLite fallback
        try {
            $count = DB::table('sessions')->count();
            echo "sessions table exists (fallback). rows: $count\n";
        } catch (\Throwable $e) {
            echo "sessions table not accessible: " . $e->getMessage() . "\n";
        }
    }
} catch (\Throwable $e) {
    echo "Could not query information_schema: " . $e->getMessage() . "\n";
    try {
        $count = DB::table('sessions')->count();
        echo "sessions table exists (fallback). rows: $count\n";
    } catch (\Throwable $e2) {
        echo "sessions table not accessible: " . $e2->getMessage() . "\n";
    }
}
