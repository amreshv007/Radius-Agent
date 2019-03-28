<?php
// filtering input URL by removing query part(if there is any) and adding "/issues"
function filter_url($url){ 
	$j = 0;
	for($i=0;$i<strlen($url);$i++){        // check if there is any "?"(query sign)
		if($url[$i]=='?'){
			$j = $i;
			break;
		}
	}
	if($url[$j]=='?'){
		$url = substr($url,0,$j);          // Removing query part from the input url
	}
	$last = strlen($url) - 1;
	while ($url[$last] == '/' ) {         // find index of /(slash) after pure url of gitHub repository
		$last = $last - 1;
	}
	$url = substr($url,0,$last+1);       // Removing every "/" in the last of the pure url of gitHub repository
	$l = strlen($url) - 1;
	if($url[$l] == '/'){
		$url = $url."issues";             // concatenate "issues" to get open issues URL
	}
	else{
		$url = $url."/issues";              //concatenate "/issues" to get open issues URL
	}
	return $url;
}

// Calculating total number of open issues
function find_open_issues($url){
	$html = file_get_html($url);                   // fetch html code from the URL
	$dom = new DOMDocument();                      // DOM Oblect
	@$dom->loadHTML($html);                         // Loading HTML
	$nodes = $dom->getElementsByTagName('a');       // object stored elements of every Anchor Tag
	$i = 1;
	foreach ($nodes as $node) {
		$open_issues = $node->nodeValue;
		// condition to find value of total open issues
		if(strpos($open_issues, ' Open') !== false){
			break;
		}
		$i++;
	}
	$open = (string)$open_issues;
	$open = explode(" Open",$open);
	$open_issues = $open[0];
	if($open_issues == "create an issue"){            // if there is 0 issues openned
		$open_issues = 0;
	}
	else{                                            // Get the int value from string value of total open issues
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
	return $open_issues;
}

// Explode only days from datetime format
function find_elapsed_days($elapsed){
	$after = explode(" days", $elapsed);
	$d = $after[0];
	$days = (int)$d;
	return $days;
}

// Calculate number of openned issues of within 24 hours and between 24 hours and 7 days FOR every page URL 
function find_elapsed_days_page_wise($page_url){
	$html = file_get_html($page_url);
	$curr_date = date("Y-m-d H:i:s");
	$tz = new DateTimeZone('Asia/Kolkata');                // Set time zone of india
	$count1 = 0;
	$count2 = 0;
	foreach($html->find('relative-time') as $element){
		$utc = $element->datetime;
		$dt = new DateTime($utc); 
       	$dt->setTimezone($tz);                             // convert UTC to Indian time zone
		$date = $dt->format('Y-m-d H:i:s');                  // Set a time format
		$datetime1 = new DateTime();                        // current date and time
		$datetime2 = new DateTime($date);                      // openned issues' time and date
		$interval = $datetime1->diff($datetime2);           // find difference of to time and date
		$elapsed = $interval->format('%a days');              // set format of difference
		$days = find_elapsed_days($elapsed);                 // get days in integer
		
		if($days<=0){                                        // Issues openned within 24 Hours
			$count1 = $count1 + 1;
		}
		if($days<7 && $days>0){                            // Issues openned within 1 week and after 24 hours
			$count2 = $count2 + 1;
		}
	}
	return $count1." ".$count2;
}

// function to count issues of every page url by 24 hours and 1 week
function find_issues_openned_periodically($url){
	$count1 = 0;
	$count2 = 0;
	$i = 0;
	$page_url = "";
	while($i<20){
		if($i == 0){
			$count = find_elapsed_days_page_wise($url);
		}
		else{
			$j = $i+1;
			$page_url = $url."?page=$j";
			$count = find_elapsed_days_page_wise($page_url);
		}
		$r = explode(" ", $count);
		$count1 = $count1 + $r[0];                          // sum total openned issues within 1 day of every page
		$count2 = $count2 + $r[1];              // sum total openned issues between 1 day and 7 day of every page 
		$i++;
	}
	$issues = $count1." ".$count2;
	return $issues;
}
?>
