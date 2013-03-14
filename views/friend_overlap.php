<?php

print_overlap($my_friends,$overlap_count,$connected);

function print_overlap($my_friends,$overlap_count,$connected) {
	foreach ($overlap_count as $count => $friends) {
		echo '<span class="mutual-friends">Overlap of ' . $count . ' friends between ';
		$f1=$my_friends[$friends[0]];
		$f2=$my_friends[$friends[1]];
		echo $f1. ' and ' .$f2 .'. ';
		echo "<span class='friend-id'>$friends[0]n$friends[1]</span>";
		if ($connected[$friends[0]][$friends[1]])
			echo "They're also friends.";
		echo '</span>';
		echo '<br><br>';
	}	
}