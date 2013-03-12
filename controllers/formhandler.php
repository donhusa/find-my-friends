<?php

//echo $_REQUEST['jobrequest'];

//figure out details later...
if (isset($_REQUEST['inbox']) && $_REQUEST['inbox']=="yes") {
	$scope="read_mailbox";
}
if (isset($_REQUEST['likes']) && $_REQUEST['likes']=="yes") {
	$scope="friends_education_history,friends_location,friends_work_history";
}

if (isset($_REQUEST['jobrequest'])){
	if ($_REQUEST['jobrequest']=="mut friends"){
		header( 'Location: ../mut_friends.php');
	}
	if ($_REQUEST['jobrequest']=="friend group"){
		header( 'Location: ../friend_groups.php');
	}
}
else {
	//reload the page with error message
}
