<?php
require ('resources/fb_init.php');
if ($user_id) {
  require ('models/get_friend_list.php');
  require ('models/find_group.php');
  
  $seeds=array();
  $my_friends=get_friend_list($facebook);
  $friend_groups=find_mail_groups($facebook,$user_id,$my_friends,$seeds);
  require ('models/commonalities.php');
  $friend_groups_data=find_commonalities($facebook,$friend_groups);
}

$view_title="My Friend Groups";
$view_path="views/groups_view.php";
require ('views/app_skeleton_view.php');
?>


