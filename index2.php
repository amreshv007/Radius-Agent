<?php
include 'header.php';
include 'simple_html_dom.php';
$path = 'http://si-rd10-hr09:8080/HRIS/empinfo/myinfo.do?cat=attendanceinfo&action=edit&e=2&fromdate=01%20Oct%202019&todate=10%20Oct%202019/';
// $p = 
$html = file_get_contents($path);
// print_r($html);
function get_string_between($string, $start, $end) {
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}
$arr = explode('<table>', $html);
print_r($arr);
echo "hello";

include 'footer.php';
?>
