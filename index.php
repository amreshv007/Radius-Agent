<?php
include 'simple_html_dom.php';
$path = 'http://svms.lge.com/pbf/system/navigation/intro.dev';
// $p = 
$html = file_get_contents($path);
print_r($html);
echo "hello";
// print()
?>
