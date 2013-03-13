<?php
require ('resources/fb_init.php');
if ($user_id) {
  require ('models/get_friend_list.php');
  require ('models/get_mutual_friends.php');
  
  if (isset($_REQUEST['mut_groups'])) $num_batches=$_REQUEST['mut_groups'];
  else $num_batches=3;//default

  $my_friends=array(); $mutual_friends=array();
  $connected=array(); $overlap=array();
  
  get_mutual_friends($facebook,$my_friends,$mutual_friends,$connected,$overlap,$num_batches);
  $overlap_count=count_overlap($overlap);
  // echo '<pre>';
  // print_r($overlap_count);
  // echo '</pre>';
}

$scripts="<script src='javascript/friend_obtainer.js'></script>";
$view_title="My Friends with the Most Mutual Friends";
$view_path="views/friend_overlap.php";
require ('views/app_skeleton_view.php');
?>