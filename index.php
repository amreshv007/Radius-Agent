<?php
include 'simple_html_dom.php';
$path = 'http://si-rd10-hr09:8080/HRIS/empinfo/myinfo.do?cat=attendanceinfo&action=edit&e=2&fromdate=01%20Oct%202019&todate=10%20Oct%202019';
// $p = 
$html = file_get_contents($path);
echo $html;
// print()
?>
