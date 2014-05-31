<?php
// check if request exists
if (!empty($_REQUEST['location'])){
	
	// receive values
	$search_type = $_REQUEST['search_type'];
	$algorithym = $_REQUEST['algorithym'];
	
	// include file to do call to census data
	
	//process selected algorythms
	
	
	
}




?><!DOCTYPE html>
<html>
<head>
  <title>Census SNAP</title>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <style>
	html, body, #map-canvas {
	  height: 100%;
	  margin: 0px;
	  padding: 0px
	}
	
	#menu{
		position:absolute;
		top:20px;
		left:150px;
		display: block;
		height:100px;
		width:280px;
		background-color: #fff;
		opacity: 0.95;
		z-index: 10;
		text-align: center;
	}
	
	input {
		background-color: #fff;
		
	}
	
  </style>
  
  <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
  
  
  <script src="/bootstrap/js/bootstrap.min.js" type="javascript" /></script>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script>
	var map;
	function initialize() {
	var mapOptions = {
	  zoom: 10,
	  center: new google.maps.LatLng(33.7677,-84.4206)
	};
	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
	}

	google.maps.event.addDomListener(window, 'load', initialize);

  </script>
</head>
<body>
	<div id="map-canvas"></div>
	<div id="menu">
		
		<div id="form">
			<form action="/" method="get" class="navbar-form navbar-left" >
				<input type="radio" name="search_type" value="address" checked="checked">Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="search_type" value="city">City
				<br>
				<label>Algorithym</label>
				<select name="algorythym">
					<option value="a">a</option>
					<option value="b">b</option>
				</select>
				<br>
				<input type="text" name="location" class="form-control" placeholder="Search" width="100px;">
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		
	</div>

</body>
</html>

