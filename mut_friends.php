<?php
require ('resources/fb_init.php');
if ($user_id) {
  require ('models/get_friend_list.php');
  require ('models/get_mutual_friends.php');
  
  $my_friends=array();
  $mutual_friends=array();
  $connected=array();
  $overlap=array();
  get_mutual_friends($facebook,$my_friends,$mutual_friends,$connected,$overlap);
  $overlap_count=count_overlap($overlap);
}

$view_title="My Friends with the Most Mutual Friends";
$view_path="views/friend_overlap.php";
require ('views/app_skeleton_view.php');
?>