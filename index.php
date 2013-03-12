<?php
include ('resources/fb_init.php');
if ($user_id) {
  //include ('status_feed_parser.php');
  //include ('tests/find_group_tests.php');
  include ('get_mutual_friends.php');
  include ('find_group.php');

  $my_friends=array();
  $mutual_friends=array();
  $connected=array();
  $overlap=array();
  //get_mutual_friends($facebook,$my_friends,$mutual_friends,$connected,$overlap);
  //$overlap_count=count_overlap($overlap);
  
  // $seeds=array();
  // $my_friends=get_friend_list($facebook);
  // $friend_groups=find_mail_groups($facebook,$user_id,$my_friends,$seeds);
  // include ('commonalities.php');
  // $friend_groups_data=find_commonalities($facebook,$friend_groups);
  // include ('group_view.php');

  // show_groups($facebook, $friend_groups_data);
}

$view_path="views/action_form.php";
include ('views/app_skeleton_view.php');
?>


