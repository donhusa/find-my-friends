 <?php

$BATCH_SIZE=25; //number of friend queries per batch

/*
--->my_friends[id] => name
--->mutual_friends[friend_id] => array of mutual friends (with me) {id, name}
--->connected[f1][f2] => whether f1 and f2 are friends
--->overlap[f1][f2] => array of shared friends (with each other and me) {id, name}
*/

function get_mutual_friends($facebook,&$my_friends,&$mutual_friends,
							&$connected,&$overlap,$num_batches){
	$my_friends=get_friend_list($facebook);
	$batch_response=fb_friend_query($facebook, $my_friends, $num_batches);
	$mutual_friends=json_decoder($facebook, $my_friends, $batch_response);
	find_overlap_n_connected($facebook, $mutual_friends,$overlap,$connected);
}

function count_overlap(&$overlap) {
	foreach ($overlap as $f1 => $intermed) { 
		foreach ($intermed as $f2=>$shared_friends) {
			$index = count($overlap[$f1][$f2]);
			if (!isset($overlap_count[$index])) {
				$overlap_count[$index]=array($f1,$f2);
			}
			/*else { // notice!!! only look at the id's 2 at a time (might get rid of this)
				// entries overwrite each other... 
				$overlap_count[$index]=
					array_merge($overlap_count[$index],array($f1,$f2));
			}*/
		}
	}
	krsort($overlap_count);
	return $overlap_count;
}

/*
Ask FB for a list of mutual friends for each of your friends
Batch requests of size BATCH_SIZE used to increase performance
Batch requests return JSON strings   
*/
function fb_friend_query($facebook, $my_friends,$num_batches) {
	global $BATCH_SIZE;

	//used num_batches, as full_batches would take way too long
	$full_batches= floor(count($my_friends)/$BATCH_SIZE);
	reset($my_friends);
	for ($i=0;$i< $num_batches /*$full_batches*/;$i++){
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
	return $batch_response;
}
/*
mutual_friends[friend][index][name] gives name of friend's friend (also your fr.)
*/
function json_decoder($facebook, $my_friends, $batch_response) {
	global $BATCH_SIZE;

	reset($my_friends);
	foreach ($batch_response as $b_ind => $response) {
		for ($j=0;$j<$BATCH_SIZE;$j++){
			$temp = json_decode($response[$j]['body'],true /*assoc*/, 4 /*depth*/);
			$mutual_friends[key($my_friends)] = $temp['data']; 
			next($my_friends);
		}
	}
	reset($my_friends);
	return $mutual_friends;
}


/*
mut_id_map allows mutual friend id's to be iterated over
	index => friend id
aka the friends used for the app!!
*/

function find_overlap_n_connected($facebook, $mutual_friends,&$overlap,&$connected){
	$i=0;
	foreach ($mutual_friends as $friend_id => $mut) {
		$mut_id_map[$i]=$friend_id;
		$i++;
	}
	for ($i=0;$i<count($mutual_friends);$i++) {
		$curr_friend = $mut_id_map[$i];
		for ($j=0;$j<count($mutual_friends);$j++) {
			$curr_comp_fr = $mut_id_map[$j];
			if (($i != $j) ) {
				if (!isset($overlap[$curr_friend][$curr_comp_fr])) {
					$intersect=find_friend_intersect($mutual_friends[$curr_friend],
							$mutual_friends[$curr_comp_fr]);
					$conn=find_friend_connection($mutual_friends[$curr_friend],
							$mutual_friends[$curr_comp_fr],$curr_friend,$curr_comp_fr);
					if (count($intersect)>0) {
						$overlap[$curr_friend][$curr_comp_fr] = $intersect;
						$overlap[$curr_comp_fr][$curr_friend] = $intersect;
					}
					$connected[$curr_friend][$curr_comp_fr] = $conn;
					$connected[$curr_comp_fr][$curr_friend] = $conn;
				}

			}
		}
	}
}

/*
//print_r($mutual_friends);
reset($mutual_friends);
for ($i=0;$i<count($mutual_friends);$i++) {
	echo key($mutual_friends) ." " . $my_friends[key($mutual_friends)];
	echo '<br>';
	print_r(current($mutual_friends));
	echo '<br><br>';
	next($mutual_friends);
}*/

function find_friend_connection ($arr1, $arr2, $f1, $f2) {
	foreach ($arr1 as $i => $friend1) {
		if ($friend1['id']==$f2) return true;
	}
	return false;
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
