<?php
require ('resources/fb_init.php');
if ($user_id) {
  //require ('status_feed_parser.php');
  require ('models/get_friend_list.php');
  require ('models/find_group.php');

  // $my_friends=array();
  // $mutual_friends=array();
  // $connected=array();
  // $overlap=array();
  // get_mutual_friends($facebook,$my_friends,$mutual_friends,$connected,$overlap);
  // $overlap_count=count_overlap($overlap);
  
   $seeds=array();
  $my_friends=get_friend_list($facebook);
  $friend_groups=find_mail_groups($facebook,$user_id,$my_friends,$seeds);
  require ('models/commonalities.php');
  $friend_groups_data=find_commonalities($facebook,$friend_groups);
  // require ('group_view.php');

  // show_groups($facebook, $friend_groups_data);
}

$view_path="views/groups_view.php";
require ('views/app_skeleton_view.php');
?>


