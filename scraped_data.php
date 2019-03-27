<?php
include_once 'simple_html_dom.php';
include 'function.php';
$url = $_GET['url'];
$url = filter_url($url);
$html = file_get_html($url);

$open_issues = find_open_issues($html);

?>
