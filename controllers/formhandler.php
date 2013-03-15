<?php

if (isset($_REQUEST['likes']) && $_REQUEST['likes']=="yes") {
	$scope="friends_education_history,friends_location,friends_work_history";
}
//scope stuff ^
//what to do when authorization error 

// names n images -> tooltip

//let user enter in friends, and have common interests for them shown
	//create your own groups!


$GET_string="";

if (isset($_REQUEST['jobrequest'])){
	if ($_REQUEST['jobrequest']=="mut friends"){
		add_to_GET_string($GET_string, 'mut_groups');
		add_to_GET_string($GET_string, 'get_pix');
		header( 'Location: ../mut_friends.php'.$GET_string);
	}
	if ($_REQUEST['jobrequest']=="friend group"){
		add_to_GET_string($GET_string, 'num_queries');
		
		//only if user checks the permissions box?
			//can add when there's another way to form groups
		if ($_REQUEST['mail_perm']=="not"){
			$theurl='https://www.facebook.com/dialog/oauth/?client_id='.
				$_REQUEST['appid']. '&redirect_uri='.$_REQUEST['baseurl'].
				'friend_groups.php'.$GET_string.'&scope=read_mailbox';
			header('Location: '.$theurl);
		}
		else { //already have permission
			header( 'Location: ../friend_groups.php'.$GET_string);
		}

	}
}
else {
	//reload the page with error message
}

add_to_GET_string($GET_string, 'num_queries');
function add_to_GET_string(&$GET_string,$var_name){
	if (isset($_REQUEST[$var_name])) {
		if ($GET_string=="") $GET_string=$GET_string."?";
		else $GET_string=$GET_string."&";
		$GET_string=$GET_string.$var_name."=".$_REQUEST[$var_name];
	}
}
