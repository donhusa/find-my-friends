<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#" lang="en">
  <head>
    <?php include('resources/meta_tags.php');?>
    <?php if(isset($scripts)) echo $scripts; ?>
  </head>
  <body>
    <div id="fb-root"></div>
    <?php include ('resources/fb_js_init.php');?>

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
        
        <a href="<?php echo AppInfo::getUrl(); ?>" class="facebook-button" >&nbsp; Go to App's Home Page &nbsp;</a>

      </div>
      <?php } else { ?>
      <div>
        <h1>Welcome to Find My Friends!</h1>
        <div class="fb-login-button"
        data-scope="friends_education_history,friends_location,friends_work_history"></div>
      <!--data-scope="user_activities,user_hometown,user_location,user_status,user_education_history,
      user_groups,user_likes,user_photos,user_work_history,friends_education_history,friends_groups,friends_likes,friends_work_history,friends_hometown,friends_location,read_stream"-->
      <!--read stream gives feed wall access-->
      </div>
      <?php } ?>
    </header>

    <?php
      if ($user_id) {
    ?>
    <section id="overlap" class="clearfix">
      <h1><?php echo $view_title; ?></h1>

      <div id="overlap-text">
          <?php
            include ($view_path); //sub in the proper view for the page!!
          ?>
      </div>
    </section>
    <?php
      }
    ?>
  </body>
</html>