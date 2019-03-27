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

function find_open_issues($html){
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$nodes = $dom->getElementsByTagName('a');
	$i = 1;
	foreach ($nodes as $node) {
		echo $i." ".$node->nodeValue."<br>";
		if($i == 53){
			$open_issues = $node->nodeValue;
		}
		$i++;
	}
	$open = (string)$open_issues;
	$open = explode(" Open",$open);
	$open_issues = $open[0];
	echo $open_issues."<br>";
	return $open_issues;
}





?>