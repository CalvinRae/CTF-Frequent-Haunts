<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create Post</title>
	<link rel="stylesheet" href="forms.css">
</head>
<body>
    <h1 title="Page Title">Create Post</h1>

	<form action=create_post.php method="POST" enctype="multipart/form-data">
	<label>Upload your image:</label><br>
	<input type="file" id="imageUpload" name="image"><br>
	<button type=submit>Post</button>
	</form>
</body>
</html>

<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['userID'])) {
    die("User not logged in");
}

$userID = $_SESSION['userID'];

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0){

    $tmpPath = $_FILES['image']['tmp_name'];
    $uploadPath = __DIR__ . "/uploads/" . $_FILES['image']['name'];
    $accessPath = "/uploads/" . $_FILES['image']['name'];

    if (!is_dir(__DIR__ . "/uploads")) {
        mkdir(__DIR__ . "/uploads");
    }

    if (!move_uploaded_file($tmpPath, $uploadPath)) {
        die("File upload failed");
    }

    $gps = getGps($uploadPath);

    $query = $db->prepare("
    INSERT INTO Posts (userID, imagePath, latitude, longitude)
    VALUES (:uid, :ipath, :lat, :lng)
    ");

    if ($query->execute([
        "ipath" => $accessPath,
        "lat"   => $gps['latitude'],
        "lng"   => $gps['longitude'],
        "uid"   => $userID
    ])) {
        echo "Post upload successful";
    } else {
        echo "Database insert failed";
    }
}

function getGps($imagePath){
    $exif = exif_read_data($imagePath);

    if(!$exif) return null;

    if(isset($exif['GPSLatitude'], $exif['GPSLongitude'])) {

        $lat=$exif['GPSLatitude'];
        $lng=$exif['GPSLongitude'];

        if(gettype($lat)=="array"){
            $lat = gpsToDecimal($lat, $exif['GPSLatitudeRef']);
        }
        if(gettype($lng)=="array"){
            $lng = gpsToDecimal($lng, $exif['GPSLatitudeRef']);
        }

        return [
            'latitude' => $lat,
            'longitude' => $lng
        ];
    }

    return null;
}

function gpsToDecimal($coord, $ref) {

    $degrees = explode('/', $coord[0]);
    $minutes = explode('/', $coord[1]);
    $seconds = explode('/', $coord[2]);

    $d = $degrees[0] / $degrees[1];
    $m = $minutes[0] / $minutes[1];
    $s = $seconds[0] / $seconds[1];

    $decimal = $d + ($m / 60) + ($s / 3600);

    if ($ref == 'S' || $ref == 'W') {
        $decimal = -$decimal;
    }

    return $decimal;
}
?>