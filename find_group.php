<?php

/*
Inputs
--->my_friends[id] => name
--->mutual_friends[friend_id] => array of mutual friends (with me) {id, name}
--->connected[f1][f2] => whether f1 and f2 are friends
--->overlap[f1][f2] => array of shared friends (with each other and me) {id, name}
*/

//print_r($overlap);

foreach ($overlap as $f1 => $intermed) { 
	foreach ($intermed as $f2=>$shared_friends) {
		$index = count($overlap[$f1][$f2]);
		if (!isset($overlap_count[$index])) {
			$overlap_count[$index]=array($f1,$f2);
		}
		/*else { // notice!!! only look at the id's 2 at a time (might get rid of this)
			$overlap_count[$index]=
				array_merge($overlap_count[$index],array($f1,$f2));
		}*/
	}
}

krsort($overlap_count);

foreach ($overlap_count as $count => $friends) {
	echo 'Overlap of ' . $count . ' friends between ';
	$f1=$my_friends[$friends[0]];
	$f2=$my_friends[$friends[1]];
	echo $f1. ' and ' .$f2 .'. ';
	if ($connected[$friends[0]][$friends[1]])
		echo "They're also friends.";
	//print_r($friends);
	echo '<br><br>';
}