<?php


//figure out details later...
if (isset($_REQUEST['inbox']) && $_REQUEST['inbox']=="yes") {
	$scope="read_mailbox";
}
if (isset($_REQUEST['likes']) && $_REQUEST['likes']=="yes") {
	$scope="friends_education_history,friends_location,friends_work_history";
}


//scope stuff ^



//ajax requests to get names of friends in common!!

//hide n show slide bars w jquery

//let user enter in friends, and have common interests for them shown
	//create your own groups!

//have browser JS get pictures for each person - option w checkbox?
	//requires sending IDs to browser
//  https://graph.facebook.com/donhusa/picture

$GET_string="";

if (isset($_REQUEST['jobrequest'])){
	if ($_REQUEST['jobrequest']=="mut friends"){
		add_to_GET_string($GET_string, 'mut_groups');
		header( 'Location: ../mut_friends.php'.$GET_string);
	}
	if ($_REQUEST['jobrequest']=="friend group"){
		add_to_GET_string($GET_string, 'num_queries');
		header( 'Location: ../friend_groups.php'.$GET_string);
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
