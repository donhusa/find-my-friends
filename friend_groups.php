<?php
require ('resources/fb_init.php');
if ($user_id) {
  require ('models/get_friend_list.php');
  require ('models/find_group.php');
  require ('models/commonalities.php');

  if (isset($_REQUEST['num_queries']) ) $num_queries=$_REQUEST['num_queries'];
  else $num_queries=30;//default

  $error=0;
  try {
  $seeds=array();
  $my_friends=get_friend_list($facebook);
  $friend_groups=find_mail_groups($facebook,$user_id,$my_friends,$seeds,$num_queries);
  $friend_groups_data=find_commonalities($facebook,$friend_groups);
	}
	catch (\Exception $e) {
		$error=1;
	}
}

$view_title="My Friend Groups";
$view_path="views/groups_view.php";
require ('views/app_skeleton_view.php');
?>


