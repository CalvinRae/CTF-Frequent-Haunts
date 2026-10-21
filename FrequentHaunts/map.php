<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Map</title>
</head>
<body>
    <h2 title="Page Title">Map</h2>

<div id="googleMap" style="width:100%;height:900px;">

</div>

<script>
function interactiveMap(){
	//create the main map
	var mapProp={
		center: new google.maps.LatLng(51.508742,-0.120850),
		zoom:5,
	};
	map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>

<script>
function addIcon(path,lat,long){
	//adds the logo icon to london for testing, remove later
	const icon = {
		url: path,
		scaledSize: new google.maps.Size(100,100),
		anchor: new google.maps.Point(50,110)
	};
	const borderIcon = {
		url: "border.png"
	}
	var marker = new google.maps.Marker({
		position:new google.maps.LatLng(lat,long),
		icon:icon
	});
	var border = new google.maps.Marker({
		position:new google.maps.LatLng(lat,long),
		icon: borderIcon
	});
	marker.setMap(map);
	border.setMap(map);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=[your_key_here]&callback=interactiveMap"></script>

</body>
</html>

<?php
//connect to database
require_once("db.php");

//get posts
$sql = "SELECT * FROM Posts";
$result = $db->query($sql);

foreach ($result as $row) {
	echo "<script>addIcon('".$row["imagePath"]."',".(string) $row["latitude"].",".(string) $row["longitude"].");</script>";
}
?>