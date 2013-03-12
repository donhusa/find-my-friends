<?php
include ('resources/fb_init.php');
if ($user_id) {
  //include ('status_feed_parser.php');
  include ('get_mutual_friends.php');
  include ('find_group.php');

  $my_friends=array();
  $mutual_friends=array();
  $connected=array();
  $overlap=array();
  get_mutual_friends($facebook,$my_friends,$mutual_friends,$connected,$overlap);
  $overlap_count=count_overlap($overlap);
}

$view_path="views/friend_overlap.php";
include ('views/app_skeleton_view.php');
?>