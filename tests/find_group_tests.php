<?php
test_intersect();
function test_intersect() {
	echo 'testing';
	$arr=array(0 => 
			array('name' => 'friend1',
				  'id'   => 12),
			1=>
			array('name' => 'friend2',
				  'id'   => 13),
			2=>
			array('name' => 'friend4',
				  'id'   => 15));
	$arr2=array(0 => 
			array('name' => 'friend2',
				  'id'   => 13),
			1=>
			array('name' => 'friend3',
				  'id'   => 14),
			2=>
			array('name' => 'friend4',
				  'id'   => 15));
	print_r($arr);
	print_r($arr2);
	echo "inter: ";
	$inter= find_friend_intersect($arr,$arr2);

	echo '<br>---<br>';
	print_r($inter);
	echo '<br>---<br>';
	$conn = find_friend_connection($arr, $arr2, 12, 15);
	echo 'conn: ';
	if ($conn) echo 'friends';
	else echo 'not friends';

}

function find_friend_connection ($arr1, $arr2, $f1, $f2) {
	foreach ($arr1 as $i => $friend1) {
		if ($friend1['id']===$f2) return true;
	}
	return false;
}

function find_friend_intersect ($arr1, $arr2) {
	foreach ($arr1 as $i => $friend1) {
		foreach ($arr2 as $j => $friend2) {
			if ($friend1['id']===$friend2['id']) {
				$intersection[] = $friend1;
			}
		}
	}
	return $intersection;
}

//compare inner
function compare_ppl ($friend1, $friend2) {
	echo '<br>---compare---<br>';
	print_r( $friend1);
	print_r($friend2);
	if ($friend1['id'] === $friend2['id']) {
		echo 'equality';
		return 0;//0 for equality
	}
	echo 'inequality';
	return 1;
}
function zheros($index1, $index2){
	echo '<br>---comp ind' .$index1 .' '.$index2. '---<br>';
	return 0;
}
