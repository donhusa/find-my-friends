<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE /*| E_NOTICE*/);
//ini_set('memory_limit', '-1'/*'128M'*/); 

// Provides access to app id and app secret
require_once('AppInfo.php');

// Enforce https on production
if (substr(AppInfo::getUrl(), 0, 8) != 'https://' && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
  header('Location: https://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  exit();
}
require_once('utils.php');
require_once('sdk/src/facebook.php');

$facebook = new Facebook(array(
  'appId'  => AppInfo::appID(),
  'secret' => AppInfo::appSecret(),
  'sharedSession' => true,
  'trustForwarded' => true,
));

$user_id = $facebook->getUser();
if ($user_id) {
  try {
    $basic = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    // If the call fails we check if we still have a user. The user will be
    // cleared if the error is because of an invalid accesstoken
    if (!$facebook->getUser()) {
      header('Location: '. AppInfo::getUrl($_SERVER['REQUEST_URI']));
      exit();
    }
  }
  //include ('status_feed_parser.php');

  include ('get_mutual_friends.php');



  include ('find_group.php');

  include ('examples/heroku-queries.php');
}
// Fetch the basic info of the app that they are using
$app_info = $facebook->api('/'. AppInfo::appID());
$app_name = idx($app_info, 'name', '');
?>

<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />

    <title><?php echo he($app_name); ?></title>
    <link rel="stylesheet" href="stylesheets/screen.css" media="Screen" type="text/css" />
    <link rel="stylesheet" href="stylesheets/mobile.css" 
        media="handheld, only screen and (max-width: 480px), only screen and (max-device-width: 480px)" type="text/css" />
    <!--[if IEMobile]>
    <link rel="stylesheet" href="mobile.css" media="screen" type="text/css"  />
    <![endif]-->
    <meta property="og:title" content="<?php echo he($app_name); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo AppInfo::getUrl(); ?>" />
    <meta property="og:image" content="<?php echo AppInfo::getUrl('/logo.png'); ?>" />
    <meta property="og:site_name" content="<?php echo he($app_name); ?>" />
    <meta property="og:description" content="My first app" />
    <meta property="fb:app_id" content="<?php echo AppInfo::appID(); ?>" />

    <script type="text/javascript" src="/javascript/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/javascript/share_actions.js"></script>
    <!--[if IE]>
      <script type="text/javascript">
        var tags = ['header', 'section'];
        while(tags.length)
          document.createElement(tags.pop());
      </script>
    <![endif]-->
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
        <h1>Welcome</h1>
        <div class="fb-login-button" data-scope="user_activities,user_hometown,user_location,user_status,user_education_history,user_groups,user_likes,user_photos,user_work_history,friends_education_history,friends_groups,friends_likes,friends_work_history,friends_hometown,friends_location,read_stream"></div>
      <!--read stream gives feed wall access-->
      </div>
      <?php } ?>
    </header>

    <?php
      if ($user_id) {
    ?>

    <?php include('examples/api-examples.php');?>

    <?php
      }
    ?>
  </body>
</html>
