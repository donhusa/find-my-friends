<?php

/*
Inputs
--->my_friends[id] => name
--->mutual_friends[friend_id] => array of mutual friends (with me) {id, name}
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
	echo $my_friends[$friends[0]]. ' and ' .$my_friends[$friends[1]];
	//print_r($friends);
	echo '<br><br>';
}