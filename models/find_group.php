<?php

function find_mail_groups($facebook,$user_id, $my_friends,&$individuals,$num_queries){
	$friend_groups=get_mail_data($facebook, $num_queries);
	remove_self_from_group($friend_groups,$user_id);
	extract_individuals_n_groups($my_friends,$friend_groups,$individuals);
	return $friend_groups;
}

function get_mail_data($facebook, $num_queries) {
	$BATCH_SIZE = 15;
	
	$num_batches=0;
	while ($num_queries > 0) {
		$offset=$BATCH_SIZE * $num_batches;
		$raw_data[$num_batches] =
			$facebook->api('me/inbox?fields=to,from&limit='.$BATCH_SIZE.'&offset='.$offset);
		$num_batches++;
		$num_queries=$num_queries-$BATCH_SIZE;
	}
	$raw=array();
	foreach ($raw_data as $i => $response) {
		$raw=array_merge($raw,$response['data']);
	}

	$friend_groups=array();
	$i=0;
	foreach ($raw as $i => $to) {
		$messaged_friends=$to['to']['data'];
		if (count($messaged_friends)<20) {
			$friend_groups[$i]=$messaged_friends;
			$i++;
		}
	}
	return $friend_groups;
}

function remove_self_from_group(&$friend_groups,$user_id) {
	foreach ($friend_groups as $i =>$ppl_info) {
		for($j=0; $j<count($ppl_info);$j++) {
			if ($ppl_info[$j]['id']==$user_id) {
				unset($ppl_info[$j]);
				$ppl_info=array_values($ppl_info);
			}
		}
		$friend_groups[$i]=$ppl_info;
	}
}

function extract_individuals_n_groups($my_friends,&$friend_groups,&$individuals){
	foreach ($friend_groups as $i => $ppl_info) {
		if (count($ppl_info)==1) {
			$individuals=array_merge($individuals,$ppl_info);
			unset($friend_groups[$i]);
		}
	}
	$friend_groups=array_values($friend_groups);

	// make sure everyone is friends with you; eliminate non-friends from group
	foreach($friend_groups as $i=>$ppl_info) {
		foreach ($ppl_info as $j=>$person_info) {
			$group_person_id = $person_info['id'];
			if (!isset($my_friends[$group_person_id])) {
				unset($friend_groups[$i][$j]);
			}
		}
		$friend_groups[$i]=array_values($friend_groups[$i]);
	}
}

