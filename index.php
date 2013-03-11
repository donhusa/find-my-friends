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
    <script type="text/javascript">
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?php echo AppInfo::appID(); ?>', // App ID
          channelUrl : '//<?php echo $_SERVER["HTTP_HOST"]; ?>/channel.html', // Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true // parse XFBML
        });

        // Listen to the auth.login which will be called when the user logs in
        // using the Login button
        FB.Event.subscribe('auth.login', function(response) {
          // We want to reload the page now so PHP can read the cookie that the
          // Javascript SDK sat. But we don't want to use
          // window.location.reload() because if this is in a canvas there was a
          // post made to this page and a reload will trigger a message to the
          // user asking if they want to send data again.
          window.location = window.location;
        });

        FB.Canvas.setAutoGrow();
      };

      // Load the SDK Asynchronously
      (function(d, debug){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
         ref.parentNode.insertBefore(js, ref);
      }(document, /*debug*/ false));
    </script>

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
