<?php

/**
 * @return the value at $index in $array or $default if $index is not set.
 */
function idx(array $array, $key, $default = null) {
  return array_key_exists($key, $array) ? $array[$key] : $default;
}

function he($str) {
  return htmlentities($str, ENT_QUOTES, "UTF-8");
}


function print_r_html ($arr) {
    ?><pre><?
    print_r($arr);
    ?></pre><?
}


// FB API GLOBAL SCOPE ONLY!!!
/*function getFriends($person,$limit=0){
	echo "got here";
	if ($limit==0) { //no query limit
		$temp= $facebook->api('/me?fields=friends.limit(10)','GET');
		echo 'ok';
		return $temp['friends']['data'];
	}
	return;
	$temp = $facebook->api('/'.$person.'?fields='.$field.'.limit('$limit')','GET');
	return $temp[$field]['data'];
}*/
