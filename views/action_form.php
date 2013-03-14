<form action="controllers/formhandler.php" method="post">

<select name="jobrequest">
	<option value = "mut friends">Mutual Friends</option>
	<option value = "friend group">Friend Group</option>
</select>
<br>
<!-- 
<input type="checkbox" name="inbox" value="yes">Use data from your inbox?<br>
<input type="checkbox" name="likes" value="yes">Use information about your friends' likes?<br>
 -->

Customize your response - mutual friends:<br>
Faster<input type="range" name="mut_groups" min="1" max="5" value="3" step="1" />More Results<br>

Customize your response - friend groups:<br>
<small>(Please note that this option needs access to your messages)</small><br>
Faster<input type="range" name="num_queries" min="5" max="75" value="25" step="5" />More Results<br>

<!-- <a href="#" class="facebook-button" id="postToWall" data-url="http://findmyfriends-dev.localhost:8888/">
                <span class="plus">Post to Wall</span>
</a>
<a href="#" class="facebook-button" > lol what's going on </a> -->
<?php 
$perm=$facebook->api('me/permissions');
$perm=$perm['data'][0];

$mail_perm = isset($perm['read_mailbox'])? "set":"not";
?>
<input type="hidden" name="appid" value="<?php echo AppInfo::appID(); ?>">
<input type="hidden" name="baseurl" value="<?php echo AppInfo::getUrl(); ?>">
<input type="hidden" name="mail_perm" value="<?php echo $mail_perm; ?>">
<input class="facebook-button" type="submit" name="formsubmit" value="Submit">
</form>
<br>