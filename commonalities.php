 <?php

 function find_commonalities($facebook, $friend_groups){
 	//take in query fields as input
 	
 	/*
	friend_groups_data =>
		[i] group # =>
			[j] person #
			[common] - loc, sch, work (if majority was found)
 	*/
 	$friend_groups_data=array();
 	foreach ($friend_groups as $i => $group) {
 		foreach ($group as $j => $person) {
 			$friend_info=$facebook->api('/'.$person['id'].'?fields=name,location,education,work','GET');
 			$friend_groups_data[$i][$j]=$friend_info;
 		}

		//for each person in the group, compare interests
		$common=array();
 		foreach ($group as $j => $p) {
 			$loc=$friend_groups_data[$i][$j]['location']['name'];
 			(isset($common['loc'][$loc]))? $common['loc'][$loc]++: $common['loc'][$loc]=1;

 			$edu=$friend_groups_data[$i][$j]['education'];
 			if (count($edu)>1){
	 			foreach ($edu as $sch_ind => $sch) {
	 				$sch_name=$sch['school']['name'];
	 				(isset($common['sch'][$sch_name]))? $common['sch'][$sch_name]++: $common['sch'][$sch_name]=1;
	 			}
 			}
 			else {
	 			$sch_name=$edu['school']['name'];
	 			(isset($common['sch'][$sch_name]))? $common['sch'][$sch_name]++: $common['sch'][$sch_name]=1; 				
 			}

 			$work=$friend_groups_data[$i][$j]['work'];
 			if (count($work)>1){
	 			foreach ($work as $w_ind => $w_place) {
	 				$w_name=$w_place['employer']['name'];
	 				(isset($common['work'][$w_name]))? $common['work'][$w_name]++: $common['work'][$w_name]=1;
	 			}
 			}
 			else {
	 			$w_name=$work['employer']['name'];
	 			(isset($common['work'][$w_name]))? $common['work'][$w_name]++: $common['work'][$w_name]=1; 				
 			}
 			//category_search($friend_groups_data, $common, 'work', 'employer', 'name');
 		}

 	// 	echo "<pre>";
		// print_r($common);
		// echo "</pre>------";

		foreach ($common as $category => $places) {
			arsort($common[$category]);
		}
					
		$common_majority=array();
		foreach ($common as $category => $places) {
			//key() = first index = most common
			if (key($places)!='' && (count($group)/3)<=current($places)) {
				$common_majority[$category]=key($places);
			}
		}
		$friend_groups_data[$i]['common']=$common_majority;
 	}
	return $friend_groups_data;
 }

//use this to refactor
function category_search($friend_groups_data, &$common, $cat_str, $index1, $index2){
	$category=$friend_groups_data[$i][$j][$cat_str];
	if (count($category)>1){
		foreach ($category as $ind => $place) {
			$cat_name=$place[$index1][$index2];
			(isset($common[$cat_str][$cat_name]))? $common[$cat_str][$cat_name]++: $common[$cat_str][$cat_name]=1;
		}
	}
	else {
		$cat_name=$category[$index1][$index2];
		(isset($common[$cat_str][$cat_name]))? $common[$cat_str][$cat_name]++: $common[$cat_str][$cat_name]=1; 				
	}
}



