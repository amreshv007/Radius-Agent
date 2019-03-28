<?php
date_default_timezone_set('Asia/Kolkata');
echo date_default_timezone_get()."<br>";
include_once 'simple_html_dom.php';
include 'function.php';
$url = $_GET['url'];
$url = filter_url($url);
$open_issues = find_open_issues($url);
$open_issues_periodically = find_issues_openned_periodically($url);
$r = explode(" ", $open_issues_periodically);
$issues_within_a_day = (int)$r[0];
$issues_within_a_week = (int)$r[1];
$issues_after_a_week = $open_issues - $issues_within_a_week - $issues_within_a_day;
echo "count1 = ".$issues_within_a_day." count2=".$issues_within_a_week." count3=".$issues_after_a_week."<br>";
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once('header.php'); ?>
	</head>
	<body id="bodyy">
		
	</body>
</html>
