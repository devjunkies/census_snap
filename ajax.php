<?php 

$snap_array = array();

$snap_array[1]['gross'] = 1245;
$snap_array[1]['net'] = 958;
$snap_array[2]['gross'] = 1681;
$snap_array[2]['net'] = 1293;
$snap_array[3]['gross'] = 2116;
$snap_array[3]['net'] = 1628;
$snap_array[4]['gross'] = 2552;
$snap_array[4]['net'] = 1963;
$snap_array[5]['gross'] = 2987;
$snap_array[5]['net'] = 2298;
$snap_array[6]['gross'] = 3423;
$snap_array[6]['net'] = 2633;
$snap_array[7]['gross'] = 3858;
$snap_array[7]['net'] = 2968;
$snap_array[8]['gross'] = 4294;
$snap_array[8]['net'] = 3303;

if($_POST){
	if($_POST['location_data']){
		$location_data = json_decode($_POST['location_data']);
		if(isset($_POST['algorithm']) && $_POST['algorithm'] == 'a'){
			$data = getData($location_data, 'a');
			//data should have the values of randi's return for a block 
			//and any other data relevant
		}
		if(isset($_POST['algorithm']) && $_POST['algorithm'] == 'b'){
			$data = getData($location_data, 'b');
			//data should have the values of randi's return for a block 
			//and any other data relevant
		}
	}
}

function getData($location_data, $alg){
	global $snap_array;

	if($alg == 'a'){
		//get algorithm value(s)
		$data = algorithmA($location_data);
	}
	if($alg == 'b'){
		//get algorithm value(s)
		$data = algorithmB($location_data);
	}
	

	for($i = 1; $i <= count($snap_array); $i++){
		if($location_data['household_amount'] == $i){
			//found household amount to compare data to

			if($data['gross'] < $snap_array[$i]['gross'] || $data['net'] < $snap_array[$i]['net']){
				//food insecure flag red
			}else{
				//food secure flag green
			}
		}
	}
	return $data;
}

function algorithmA($location_data){

	return $data;
}

function algorithmB($location_data){
	
	return $data;
}

?>