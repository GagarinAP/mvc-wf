<?php

function p($x, $typeFlag = 0){
	$type = gettype($x);
	if($typeFlag)
		print "type: $type :<br>\n";
	$ptext = $x;
	if ($type == 'boolean')
		$ptext = $x ? 'TRUE' : 'FALSE';
	if (! in_array($type, array('array', 'object')))
		print "<div>$ptext</div>\n";
	else {
		print "<pre>"; print_r($x); print "</pre>\n";
	}
}

function vd($x){
	print "<div><pre>\n";
	var_dump($x);
	print "</pre></div>";
}

function html_table($data, $style=''){
	if(empty($data)){
		return null;
	}
	$row1 = $data[0];
	$keys = array_keys(is_array($row1) ? $row1 : get_object_vars($row1));
	
	function val($obj, $field){
		if(is_object($obj)) return $obj->{$field};
		elseif(is_array($obj)) return $obj[$field];
		return null;
	}
	
	$tabStyle = "";
	$tdStyle = "";
	if(is_string($style)){
		$tabStyle = $style;
		$tdStyle = $style;
	} else {
		if(isset($style['table']))
			$tabStyle = $style['table'];
		if(isset($style['td']))
			$tdStyle = $style['td'];
	}
	$tabStyle = "style=\"".$tabStyle."\"";
	$tdStyle = "style=\"".$tdStyle."\"";
	
	$html = "<table $tabStyle>\n";
	$html .= "<tr>\n";
	foreach($keys as $key){
		$html .= "<th>$key</th>\n";
	}
	$html .= "</tr>\n";
	
	foreach($data as $i => $unit){
		$html .= "<tr>\n";
		foreach($keys as $key){
			$val = val($unit, $key);
			$html .= "<td $tdStyle>{$val}</td>\n";
		}
		$html .= "</tr>\n";
	}
	
	$html .= "</table>";
	return $html;
}