<?php
// Simulate a POST to /login. Usage: php simulate_login.php "email" "password"
if ($argc < 3) {
    echo "Usage: php simulate_login.php email password\n";
    exit(1);
}
$email = $argv[1];
$password = $argv[2];

$url = 'http://localhost:8000/login'; // adjust if you use different dev server
$post = [
    'email' => $email,
    'password' => $password,
    '_token' => '',
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($post),
        'ignore_errors' => true,
        'timeout' => 5,
    ],
];

$context = stream_context_create($options);
try {
    $result = file_get_contents($url, false, $context);
    $code = null;
    if (isset($http_response_header)) {
        foreach ($http_response_header as $hdr) {
            if (preg_match('#HTTP/\d+\.\d+\s+(\d+)#', $hdr, $m)) {
                $code = (int)$m[1];
                break;
            }
        }
    }
    echo "HTTP status: " . ($code ?? 'unknown') . "\n";
    echo "Response length: " . strlen($result) . "\n";
    echo "First 1000 chars:\n" . substr($result, 0, 1000) . "\n";
} catch (\Throwable $e) {
    echo "Request failed: " . $e->getMessage() . "\n";
}
