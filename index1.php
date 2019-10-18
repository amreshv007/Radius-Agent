<?php include 'header.php'; ?>

<!--  xml task (START) -->
<h1>Ice Bucket Challenge</h1>
<form action="" method="POST" enctype="multipart/form-data" style="text-align:center;">
	<div style="width:100%;"><b>Note: </b>Choose (.xml) file to convert its data into a table form.</div>
         <input type="file" name="lg_xml" />
         <input type="submit"/>
</form>

 <?php if(isset($_FILES['lg_xml'])){
	include 'simple_html_dom.php';
	
	$oldPath = $_FILES['lg_xml']['tmp_name'];
	$newPath = ''.basename($_FILES['lg_xml']['name']);
	if(move_uploaded_file($oldPath, $newPath)) {
		echo "Uploaded Successfully!";
	}
	else {
		echo "Upload Failed!";
	}
// 	$html = file_get_contents('vo_config_new-d89308866ba8a8ca4df94f4e6344d9d2.xml');
	$html = file_get_contents($newPath);
	function get_string_between($string, $start, $end) {
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}
	$arr = explode('</info>', $html);
	$first = explode('<info', $arr[0]);
	$arr[0] = "<info".$first[1];
	$table = array();

	$country_list1 = array("United Kingdom","Czech Republic","Bosnia and Herzegovina","North Macedonia","Vatican City");
	$country_list2 = array("Kingdom","Republic","Herzegovina","Macedonia","City");

	for( $i = 0; $i < sizeof($arr)-1; $i++ ) {
		$temp = $arr[$i];
		// each row extraction
		$operator_country = get_string_between($temp,'<!--','-->');
		$a = explode(" ", $operator_country);
		$last = sizeof($a);
		$country_last_name = $a[$last-1];
		$country = "";
		$operator = "";
		$x = 0;
		for($k=0; $k < sizeof($country_list2); $k++){
			if($country_list2[$k] == $country_last_name){
				$country = $country.$country_list1[$k];
				$x = 1;
				break;
			}
		}
		$operator = $a[0];
		if($x==0) {
			$country = $country_last_name;
			for($j=1;$j<$last-1;$j++) {
					$operator = $operator." ".$a[$j];
			}
		}
		else {
			for($j=1;$j<$last-2;$j++) {
					$operator = $operator." ".$a[$j];
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
	<h2>Table Output</h2>
	<table class="t">
			<tr>
				<th>Country</th>
				<th>Operator</th>
				<th>MCC</th>
				<th>MNC</th>
				<th>VoLTE</th>
				<th>ViLTE</th>
				<th>VoWiFi</th>
				<th>ViWiFi</th>
			</tr>
			<?php for( $i=0; $i < sizeof($arr)-1; $i++){ ?>
			<tr>
				<?php for( $j=0; $j<8; $j++) { ?>
				<td><?php echo $table[$i][$j]; ?></td>
				<?php } ?>
			</tr>      
			<?php } ?>
	</table>
<?php } ?>

<!-- xml task (END) -->

<?php include 'footer.php'; ?>
	