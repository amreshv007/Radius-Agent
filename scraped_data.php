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
// print_r($arr);
$first = explode('<info', $arr[0]);
$arr[0] = "<info".$first[1];
// echo "0. ".$first[1];
$table = array();
for( $i = 0; $i < sizeof($arr)-1; $i++ ){
// 	echo $i.". ".$arr[$i];
	$temp = $arr[$i];
	// each row extraction
	$operator_country = get_string_between($temp,'<!--','-->');
	$a = explode(" ", $operator_country);
	$last = sizeof($a)-1;
	$country = $a[$last];
	$operator = "";
	for($i=0;$i<$last-1;$i++){
		if($i <$last-2){
			$operator = $operator.$a[$i]." ";		
		}
		else{
			$operator = $operator.$a[$i];	
		}
	}
	$mcc = get_string_between($temp,'mcc="','" mnc');
	$mnc = get_string_between($temp,'mnc="','"');
	$volte = get_string_between($temp,'support_volte="','" support_vilte');
	$vilte = get_string_between($temp,'support_vilte="','" support_vowifi');
	$vowifi = get_string_between($temp,'support_vowifi="','" support_viwifi');
	$viwifi = get_string_between($temp,'support_viwifi="','" />');
	$table[$i][0] = $country;
	$table[$i][1] = $operator;
	$table[$i][2] = $mcc;
	$table[$i][3] = $mnc;
	$table[$i][4] = $volte;
	$table[$i][5] = $vilte;
	$table[$i][6] = $vowifi;
	$table[$i][7] = $viwifi;
}
?>
<table class="table">
	<thead>
		<tr class="table_head">
			<th>S. No.</th>
			<th>Country</th>
			<th>Operator</th>
			<th>mcc</th>
			<th>mnc</th>
			<th>Volte</th>
			<th>Vilte</th>
			<th>Vowifi</th>
			<th>Viwifi</th>
		</tr>
	</thead>
	<tbody>
		<?php for( $i=0; $i < sizeof($arr)-1; $i++){ ?>
		<tr class="info">
			<td><?php echo $i+1; ?></td>
			<?php for( $j=0; $j<8; $j++) { ?>
			<td><?php echo $table[$i][$j]; ?></td>
			<?php } ?>
		</tr>      
		<?php } ?>
	</tbody>
</table>
<!-- xml task (END) -->

<?php
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
