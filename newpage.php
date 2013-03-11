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
  $seeds=array();
  $my_friends=get_friend_list($facebook);
  $friend_groups=find_mail_groups($facebook,$user_id,$my_friends,$seeds);
  include ('commonalities.php');
  $friend_groups_data=find_commonalities($facebook,$friend_groups);
  include ('group_view.php');
  // show_groups($facebook, $friend_groups_data);
}

// Fetch the basic info of the app that they are using
$app_info = $facebook->api('/'. AppInfo::appID());
$app_name = idx($app_info, 'name', '');
?>

<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
  <head>
    <?php include('resources/meta_tags.php');?>
  </head>
  <body>
    <div id="fb-root"></div>
    <?php include ('fb_js_init.php');?>

    <header class="clearfix">
      <?php if (isset($basic)) { ?>
      <p id="picture" style="background-image: url(https://graph.facebook.com/<?php echo he($user_id); ?>/picture?type=normal)"></p>

      <div>
        <h1>Welcome, <strong><?php echo he(idx($basic, 'name')); ?></strong></h1>
        <p class="tagline">
          This is the app
          <a href="<?php echo he(idx($app_info, 'link'));?>" target="_top"><?php echo he($app_name); ?></a>
        </p>
        <?php include ('share_app.php');?>
      </div>
      <?php } else { ?>
      <div>
        <h1>Welcome to Find My Friends!</h1>
        <div class="fb-login-button"
        data-scope="read_mailbox,friends_education_history,friends_location,friends_work_history"></div>
      <!--data-scope="user_activities,user_hometown,user_location,user_status,user_education_history,user_groups,user_likes,user_photos,user_work_history,friends_education_history,friends_groups,friends_likes,friends_work_history,friends_hometown,friends_location,read_stream"-->
      <!--read stream gives feed wall access-->
      </div>
      <?php } ?>
    </header>

    <?php
      if ($user_id) {
    ?>
    <?php include('view.php');?>
    <?php //include('examples/api-examples.php');?>

    <?php
      }
    ?>
  </body>
</html>
