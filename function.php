<?php
function filter_url($url){
	echo $url."<br>";
	$j = 0;
	for($i=0;$i<strlen($url);$i++){
		if($url[$i]=='?'){
			$j = $i;
			break;
		}
	}
	if($url[$j]=='?'){
		$url = substr($url,0,$j);
	}
	$last = strlen($url) - 1;
	while ($url[$last] == '/' ) {
		$last = $last - 1;
	}
	$url = substr($url,0,$last+1);
	echo $url."<br>";
	$l = strlen($url) - 1;
	if($url[$l] == '/'){
		$url = $url."issues";
	}
	else{
		$url = $url."/issues";
	}
	echo $url."<br>";
	return $url;
}

function find_open_issues($url){
	$html = file_get_html($url);
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$nodes = $dom->getElementsByTagName('a');
	$i = 1;
	foreach ($nodes as $node) {
		// echo $i." ".$node->nodeValue."<br>";
		if($i == 53){
			$open_issues = $node->nodeValue;
		}
		$i++;
	}
	$open = (string)$open_issues;
	$open = explode(" Open",$open);
	$open_issues = $open[0];
	if($open_issues == "create an issue"){
		$open_issues = 0;
	}
	else{
		$r = "";
		$i = 0;
		while($i<strlen($open_issues)){
			if($open_issues[$i]!=','){
				$r = $r.$open_issues[$i];
			}
			$i++;
		}
		$open_issues = (int)$r;
	}
	echo $open_issues."<br>";
	return $open_issues;
}

function find_elapsed_days($elapsed){
	$after = explode(" days", $elapsed);
	$d = $after[0];
	$days = (int)$d;
	return $days;
}

function find_elapsed_days_page_wise($page_url){
	$html = file_get_html($page_url);
	$curr_date = date("Y-m-d H:i:s");
	$tz = new DateTimeZone('Asia/Kolkata');
	$count1 = 0;
	$count2 = 0;
	foreach($html->find('relative-time') as $element){
		$utc = $element->datetime;
		$dt = new DateTime($utc);
       	$dt->setTimezone($tz);
		// echo $dt->format('Y-m-d H:i:s')."<br>".$curr_date."<br>";
		$date = $dt->format('Y-m-d H:i:s');
		$datetime1 = new DateTime();
		$datetime2 = new DateTime($date);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%a days');
		$days = find_elapsed_days($elapsed);
		
		if($days<=0){
			// echo "Issues openned within 24 Hours!<br>";
			$count1 = $count1 + 1;
		}
		if($days<7 && $days>0){
			// echo "Issues openned within 1 week!<br>";
			$count2 = $count2 + 1;
		}
		// echo $elapsed."<br><br>";
	}
	return $count1." ".$count2;
}

function find_issues_openned_periodically($url){
	$count1 = 0;
	$count2 = 0;
	$count3 = 0;
	$i = 0;
	$page_url = "";
	while($i<9){
		if($i == 0){
			$count = find_elapsed_days_page_wise($url);
		}
		else{
			$j = $i+1;
			$page_url = $url."?page=$j";
			echo $page_url."<br>";
			$count = find_elapsed_days_page_wise($page_url);	
		}
		$r = explode(" ", $count);
		$count1 = $count1 + $r[0];
		$count2 = $count2 + $r[1];
		$i++;
	}
	
	echo $url."<br>";
	echo "count1 = ".$count1." count2=".$count2."<br>";

	$issues = $count1." ".$count2;
	
	return $issues;
}



?>