<!DOCTYPE html>
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
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script>
  <script>

	var map;
	var marker_image = {
    url: 'http://wchurch.tv/Websites/westsideomaha/images/the_journey/neighborhood_icon.png',
    // This marker is 20 pixels wide by 32 pixels tall.
    size: new google.maps.Size(150, 150),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    anchor: new google.maps.Point(0, 32)
  };
  var marker_shape = {
      coords: [1, 1, 1, 150, 150, 150, 150 , 1],
      type: 'poly'
  };
	$(document).ready(function(){
		
		console.log('map var');
		

		function initialize() {
			var mapOptions = {
			  zoom: 10,
			  center: new google.maps.LatLng(33.7677,-84.4206)
			};


			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			console.log('map init success');
		}

		google.maps.event.addDomListener(window, 'load', initialize);
		

		$('#form').submit(function(e){
			e.preventDefault();

			var tempData = {
    	"income": {
    		"location": {lat:33.950488, lon:-84.115902},
        "_001E": {
            "title": "Total",
            "quantity": "1795"
        },
        "results": {
            "_002E": {
                "title": "Less than $10,000",
                "quantity": "136"
            },
            "_003E": {
                "title": "$10,000 to $14,999",
                "quantity": "88"
            },
            "_004E": {
                "title": "$15,000 to $19,999",
                "quantity": "137"
            },
            "_005E": {
                "title": "$20,000 to $24,999",
                "quantity": "155"
            },
            "_006E": {
                "title": "$25,000 to $29,999",
                "quantity": "30"
            },
            "_007E": {
                "title": "$30,000 to $34,999",
                "quantity": "181"
            },
            "_008E": {
                "title": "$35,000 to $39,999",
                "quantity": "151"
            },
            "_009E": {
                "title": "$40,000 to $44,999",
                "quantity": "95"
            },
            "_010E": {
                "title": "$45,000 to $49,999",
                "quantity": "95"
            },
            "_011E": {
                "title": "$50,000 to $59,999",
                "quantity": "258"
            },
            "_012E": {
                "title": "$60,000 to $74,999",
                "quantity": "198"
            },
            "_013E": {
                "title": "$75,000 to $99,999",
                "quantity": "240"
            },
            "_014E": {
                "title": "$100,000 to $124,999",
                "quantity": "22"
            },
            "_015E": {
                "title": "$125,000 to $149,999",
                "quantity": "0"
            },
            "_016E": {
                "title": "$150,000 to $199,999",
                "quantity": "9"
            },
            "_017E": {
                "title": "$200,000 or more",
                "quantity": "0"
            }
        }
    }
}

			processMapData('3355 SweetWater Road', tempData);
			return;
			var search_type = $('input[name=search_type]:checked', '#form').val();
			var algorithm = $('#algorithm').find(":selected").text();
			var location = $('#location').val();

			console.log(search_type, algorithm, location);

			$.ajax({
			  type: "POST",
			  url: "hungry.devjunkies.net/api", //send to randi
			  type: 'json',
			  data: {address: location, key: 'f75c106d4fbce60a31fd4ab440b0aa4a825228a8'}
			})
		  .done(function( location_data ) {
		  	//console.log(location_data);
		  	$.ajax({
				  type: "POST",
				  url: "ajax.php", //send to randi
				  type: 'json',
				  data: { search_type: search_type, algorithm: algorithm, location_data: location_data }
				}).done(function( alg_data ) {
					//console.log(alg_data);

					//processMapData(location, location_data, alg_data);
					
				}); 
		  });
		});

	});

	function processMapData(location, location_data){
		var myLatLng = new google.maps.LatLng(location_data.income.location.lat,location_data.income.location.lon);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: marker_image,
        shape: marker_shape,
        title: location,
        zIndex: 1
    });
    console.log(location_data.income._001E.quantity);
		var content = '<div>';
    	content += '<ul>';
    	content += '<li><b>Total People: ' + location_data.income._001E.quantity+ '</b></li>';
    	var amount_insecure = 0;
    _.forEach(location_data.income.results, function(val, idx, coll){
    	console.log(idx)
    	if(idx == '_002E' || idx == '_003E' || idx == '_004E' || idx == '_005E' || idx == '_006E'){
    		amount_insecure = amount_insecure + parseInt(val.quantity);
    	} 	 
    });

    
   
    content += '<li><b>Avg # Per Household: 4</b></li>';
    content += '<li><font color="red"><b>Amount Food Insecure: '+amount_insecure+'</b></font></li>';
    content += '</ul></div>';
    var infowindow = new google.maps.InfoWindow({
      content:content
  	});

    google.maps.event.addListener(marker, 'click', function() {
	    infowindow.open(map,marker);
	  });

    
		//zoom in
		map.setZoom(15);
    map.setCenter(new google.maps.LatLng(location_data.income.location.lat,location_data.income.location.lon));
	}

  </script>
</head>
<body>
	<div id="map-canvas"></div>
	<div id="menu">
		
		<div id="form">
			<form action="/" method="post" class="navbar-form navbar-left" >
				<input type="radio" name="search_type" value="address" checked="checked">Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="search_type" value="city">City
				<br>
				<label>Algorithm</label>
				<select id="algorithm" name="algorithm">
					<option value="a">A</option>
					<option value="b">B</option>
				</select>
				<br>
				<input disabled type="text" name="location" class="form-control" placeholder="Search" width="100px;" value="3355 SweetWater Road">
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		
	</div>

</body>
</html>

