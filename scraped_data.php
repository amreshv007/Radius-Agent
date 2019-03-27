<?php
include_once 'simple_html_dom.php';
include 'function.php';

$url = $_GET['url'];

$url = filter_url($url);

// $open_issues = find_open_issues($url);

$open_issues_within_24hr = find_issues_openned_within_24hrs($url);

?>
