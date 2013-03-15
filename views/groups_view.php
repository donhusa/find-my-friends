<?php

show_groups($facebook, $friend_groups_data,$error);

function show_groups($facebook, $friend_groups_data,$error){
	if ($error) {
		echo "Mailbox access is required for this part to work...<br><br> ";
		return;
	}
	foreach ($friend_groups_data as $i => $group) {
		for($j=0;$j<count($group)-1; $j++) {
			$person=$group[$j];
			echo $person['name'].'<br>';
		}

		foreach ($group['common'] as $category =>$commonality) {
			echo "Most of the group members seem to have ".$commonality." in common.<br>"; 
		}
		if(empty($group['common'])){
			echo "No common category was found...<br>";
			echo "It's possible that some group members have strict privacy settings.";
		}
		echo '<br><br>';
	}
}