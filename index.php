<?php include 'header.php'; ?>
<!--  xml task (START) -->
<?php include 'simple_html_dom.php'; ?>
<?php
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
	$last = sizeof($a);
	$country = $a[$last-1];
	$operator = $a[0];
	for($j=1;$j<$last-1;$j++){
			$operator = $operator." ".$a[$j];
	}
	$mcc = get_string_between($temp,'mcc="','" mnc');
	$mnc = get_string_between($temp,'mnc="','"');
	$volte = get_string_between($temp,'support_volte="','" support_vilte');
	$vilte = get_string_between($temp,'support_vilte="','" support_vowifi');
	$vowifi = get_string_between($temp,'support_vowifi="','" support_viwifi');
	$viwifi = get_string_between($temp,'support_viwifi="','" />');
	$table[$i][0] = $country;
// 	$table[$i][0] = $a[1];
	$table[$i][1] = $operator;
// 	$table[$i][1] = $a[0];
	$table[$i][2] = $mcc;
	$table[$i][3] = $mnc;
	if($volte == 1)
		$volte = 'O';
	else
		$volte = 'X';
	if($vilte == 1)
		$vilte = 'O';
	else
		$vilte = 'X';
	if($vowifi == 1)
		$vowifi = 'O';
	else
		$vowifi = 'X';
	if($viwifi == 1)
		$viwifi = 'O';
	else
		$viwifi = 'X';
	$table[$i][4] = $volte;
	$table[$i][5] = $vilte;
	$table[$i][6] = $vowifi;
	$table[$i][7] = $viwifi;
}
?>
<table class="t">
	<thead>
		<tr>
<!-- 			<th>S. No.</th> -->
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
		<tr>
<!-- 			<td><?php //echo $i+1; ?></td> -->
			<?php for( $j=0; $j<8; $j++) { ?>
			<td><?php echo $table[$i][$j]; ?></td>
			<?php } ?>
		</tr>      
		<?php } ?>
	</tbody>
</table>

<!-- xml task (END) -->

<!-- Form input of GitHub public Repository URL -->
<form name="form" action="scraped_data.php" method="GET" class="formclass">
	<label class="form_heading">Enter GitHub Repository URL:</label>
	<label>
		<input type="text" name="url" class="git_url" placeholder="Enter Name" />
	</label>
	<label>
		<input type="submit" name="submit" value="Submit" />
	</label>
</form>
<?php include 'footer.php'; ?>
	
