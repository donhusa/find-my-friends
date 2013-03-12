<?php

function get_friend_list($facebook) {
	$my_friends_raw = $facebook->api('/me/friends','GET');
	foreach ($my_friends_raw['data'] as $ind => $friend) {
		$my_friends[$friend['id']]=$friend['name'];
	}
	unset($my_friends_raw);
	return $my_friends;
}