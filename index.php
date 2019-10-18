<?php
include 'header.php';
include 'simple_html_dom.php';
$path = 'https://www.google.com/';
// $p = 
$html = file_get_contents($path);
print_r($html);
echo "hello";
// print()
include 'footer.php';
?>
