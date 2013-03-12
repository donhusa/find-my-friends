<?php

print_overlap();

function print_overlap() {
	global $my_friends, $overlap_count, $connected;
	foreach ($overlap_count as $count => $friends) {
		echo 'Overlap of ' . $count . ' friends between ';
		$f1=$my_friends[$friends[0]];
		$f2=$my_friends[$friends[1]];
		echo $f1. ' and ' .$f2 .'. ';
		if ($connected[$friends[0]][$friends[1]])
			echo "They're also friends.";
		echo '<br><br>';
	}	
}