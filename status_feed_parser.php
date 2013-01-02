<?php 

/*
Parses user's wall feed (requires read_stream permissions to view other's posts)
Then parses user's statuses, extracting IDs of users who liked and commented
Note: only parses for first pagination

Returns global vars:
wall_ids - id of user => frequency of post
status_ids - id of user => frequency of comment / like
*/

  //it would be more efficient if there were a way to limit the wall from showing
  //likes and other useless stuff
  $raw_wall = $facebook->api('/me/feed','GET');
  $wall = $raw_wall['data'];
  foreach ($wall as $index => $wall_post) {
    if (($wall_post['type']) && $wall_post['type']=='status'){
      $wall_poster = $wall_post['from']['id'];
      if ($wall_poster != $user_id) {
        $wall_ids[$wall_poster] = 
          ($wall_ids[$wall_poster]) ? $wall_ids[$wall_poster]+1:1;
      }
    }
  }

  $raw_status = $facebook->api('/me?fields=statuses','GET');
  $stat = $raw_status['statuses']['data'];

  //iterates over the likes and comments of each status
  foreach ($stat as $index => $status ){
    $status_likes=$status['likes']['data'];
    foreach ($status_likes as $person_index => $person){
      $person_id = $person['id'];
      if ($person_id != $user_id) {
        $status_ids[$person_id] =( $status_ids[$person_id] ?
          $status_ids[$person_id] += 1 : 1);
      }
    }
    $status_comments=$status['comments']['data'];
    foreach ($status_comments as $person_index => $person){
      $person_id = $person['from']['id'];
      if ($person_id != $user_id) {
        $status_ids[$person_id] =( $status_ids[$person_id] ?
          $status_ids[$person_id] += 1 : 1);
      }
    }
  }

  arsort($wall_ids);
  arsort($status_ids);
  //print_r($wall_ids);
  //print_r($status_ids);

  /*$NUM_SEEDS=2;
  reset($status_ids);
  for($i = 0; $i < $NUM_SEEDS; $i++ ){
    $seed_id[$i]=key($status_ids);
    next($status_ids);
  }
  print_r($seed_id);*/
  
  ?>