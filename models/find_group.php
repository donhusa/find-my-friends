<?php

function find_mail_groups($facebook,$user_id, $my_friends,&$individuals){
	$friend_groups=get_mail_data($facebook);
	remove_self_from_group($friend_groups,$user_id);
	extract_individuals_n_groups($my_friends,$friend_groups,$individuals);

	// echo "<pre>";
	// print_r($friend_groups);
	// echo "</pre>";
	return $friend_groups;
}

function get_mail_data($facebook) {
	$raw1=$facebook->api('me/inbox?fields=to,from&limit=15');
	$raw2=$facebook->api('me/inbox?fields=to,from&limit=15&offset=15');
	// $raw3=$facebook->api('me/inbox?fields=to,from&limit=15&offset=30');
	$raw1=$raw1['data'];
	$raw2=$raw2['data'];
	// $raw3=$raw3['data'];
	$raw=array_merge($raw1,$raw2);//,$raw3);
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

