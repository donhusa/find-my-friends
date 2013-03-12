<form action="controllers/formhandler.php" method="post">

<select name="jobrequest">
	<option value = "mut friends">Mutual Friends</option>
	<option value = "friend group">Friend Group</option>
</select>
<br>

<input type="checkbox" name="inbox" value="yes">Use data from your inbox?<br>
<input type="checkbox" name="likes" value="yes">Use information about your friends' likes?<br>

<input type="submit" name="formsubmit" value="Submit">
</form>