 <?php

$BATCH_SIZE=30; //number of friend queries per batch


/*
Get list of friends
--->my_friends - id => name
*/
$my_friends_raw = $facebook->api('/me/friends','GET');
foreach ($my_friends_raw['data'] as $ind => $friend) {
	$my_friends[$friend['id']]=$friend['name'];
}
unset($my_friends_raw);

/*
Ask FB for a list of mutual friends for each of your friends
Batch requests of size BATCH_SIZE used to increase performance
Batch requests return JSON strings   
*/

// NOTICE!!!!!!
// don't forget about the final batch (if it really matters)
// currently, only 2 batches are sent (for performance)
//		all analysis done from those two batches

$full_batches= floor(count($my_friends)/$BATCH_SIZE);
reset($my_friends);

for ($i=0;$i< 2/*$full_batches*/;$i++){
	//make each batch
	$batch_string='[';
	for ($j=0;$j<$BATCH_SIZE;$j++){
		$next_friend = key($my_friends);
		next($my_friends);
		if ($next_friend){
			$batch_string .='{"method":"GET","relative_url":"me/mutualfriends/'.
			 	$next_friend . '"}';
			if ($j <($BATCH_SIZE-1)) $batch_string.=',';			
		}

	}
	$batch_string .= ']';
	//send batch
	$batch_response[$i] = $facebook->api('/me','POST',array('batch'=>$batch_string));
}

/*
Decode the JSON
--->mutual_friends - friend id => array of mutual friends {id, name}
e.g. mutual_friends[friend][index][name] gives name of friend's friend (also your fr.)
*/
reset($my_friends);
foreach ($batch_response as $b_ind => $response) {
	for ($j=0;$j<$BATCH_SIZE;$j++){
		$temp = json_decode($response[$j]['body'],true /*assoc*/, 4 /*depth*/);
		$mutual_friends[key($my_friends)] = $temp['data']; 
		next($my_friends);
	}
}

$i=0;
foreach ($mutual_friends as $friend_id => $mut) {
	$mut_id_map[$i]=$friend_id;
	$i++;
}

for ($i=0;$i<count($mutual_friends);$i++) {
	$curr_friend = $mut_id_map[$i];
	for ($j=0;$j<count($mutual_friends);$j++) {
		if ($i != $j) {
			$curr_comp_fr = $mut_id_map[$j];
			echo $my_friends[$curr_friend] . '  ' . $my_friends[$curr_comp_fr];
			echo '<br>---<br>';
			print_r($mutual_friends[$curr_friend]);
			echo '<br>---<br>';
			print_r($mutual_friends[$curr_comp_fr]);
			echo '<br>---<br>';
			$overlap[$curr_friend][$curr_comp_fr] = 
				find_friend_intersect($mutual_friends[$curr_friend],
									  $mutual_friends[$curr_comp_fr],'compare_ppl');
			print_r( $overlap[$curr_friend][$curr_comp_fr]);
			echo '<br><br>';
		}
	}
}


//print_r($mutual_friends);
reset($mutual_friends);
for ($i=0;$i<count($mutual_friends);$i++) {
	echo key($mutual_friends) ." " . $my_friends[key($mutual_friends)];
	echo '<br>';
	print_r(current($mutual_friends));
	echo '<br><br>';
	next($mutual_friends);
}



function find_friend_intersect ($arr1, $arr2) {
	foreach ($arr1 as $i => $friend1) {
		foreach ($arr2 as $j => $friend2) {
			if ($friend1['id']===$friend2['id']) {
				$intersection[] = $friend1;
			}
		}
	}
	return $intersection;
}



