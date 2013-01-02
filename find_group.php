<?php

$BATCH_SIZE=30; //number of friend queries per batch

$my_friends_raw = $facebook->api('/me/friends','GET');
foreach ($my_friends_raw['data'] as $ind => $friend) {
	$my_friends[$friend['id']]=$friend['name'];
	//$my_friends_ids[]=$friend['id'];
}
unset($my_friends_raw);

//print_r($my_friends);
//echo '<br><br>blargh';

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


reset($my_friends);
foreach ($batch_response as $b_ind => $response) {
	for ($j=0;$j<$BATCH_SIZE;$j++){
		$temp = json_decode($response[$j]['body'],true /*assoc*/, 4 /*depth*/);
		$mutual_friends[key($my_friends)] = $temp['data']; 
		next($my_friends);
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


// don't forget about the final batch (if it really matters)




/*for ($i=0;$i<10;$i++) {
	$temp = $facebook->api('/me/mutualfriends/'.$my_friend_ids[$i]);
	echo $temp .'<br>';
	print_r($temp);
	echo '<br><br>';
}*/