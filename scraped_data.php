<?php
date_default_timezone_set('Asia/Kolkata');
// echo date_default_timezone_get()."<br>";
include_once 'simple_html_dom.php';
include 'function.php';

// xml task (START)
$html = file_get_contents('vo_config_new-d89308866ba8a8ca4df94f4e6344d9d2.xml');
// print_r($html);
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
// $get_element = get_string_between($html,'<!--','-->');
$arr = explode('</info>', $html);
$get_element = get_string_between($arr[0],'<info','</info>');
print_r($get_element);
for( $i = 1; $i < strlen($arr); $i++ ){
// 	$get_element = get_string_between($t,'<info','</info>');
	print_r($arr[$i]);
}
// xml task (END)

$url = $_GET['url'];
$url = filter_url($url);  // filter URL
$open_issues = find_open_issues($url); // Calculate total open issues
$open_issues_periodically = find_issues_openned_periodically($url); // Calculate openned issues day and week wise
$r = explode(" ", $open_issues_periodically); // explode by space to get openned issues
$issues_within_a_day = (int)$r[0];
$issues_within_a_week = (int)$r[1];
$issues_after_a_week = $open_issues - $issues_within_a_week - $issues_within_a_day;
$show_url = explode("/issues", $url);
$show = $show_url[0];
?>
<?php include 'header.php'; ?>
		<div class="container">
			<h1 class="heading heading2">Radius Agent</h1>
			<p><b>GitHub Repository URL:</b>"<?php echo $show; ?>"</p>
			<table class="table">
				<thead>
					<tr class="table_head">
						<th>S.No.</th>
						<th>Issues</th>
						<th>Number</th>
					</tr>
				</thead>
				<tbody>
					<tr class="info">
						<td>1.</td>
						<td>Total number of open issues</td>
						<td><?php echo $open_issues; ?></td>
					</tr>      
					<tr class="success">
						<td>2.</td>
						<td>Number of open issues that were opened in the last 24 hours</td>
						<td><?php echo $issues_within_a_day; ?></td>
					</tr>
					<tr class="danger">
						<td>3.</td>
						<td> Number of open issues that were opened more than 24 hours ago but less than 7 days ago</td>
						<td><?php echo $issues_within_a_week; ?></td>
					</tr>
					<tr class="info">
						<td>4.</td>
						<td>Number of open issues that were opened more than 7 days ago</td>
						<td><?php echo $issues_after_a_week; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
<?php include 'footer.php'; ?>
