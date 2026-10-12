<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Frequent Haunts</title>
    <link rel="stylesheet" href="homepage.css">
<script>
function writeUsername(username){
    document.getElementById("user").innerHTML=username;
}
</script>
</head>
<body>
    <div id="navbar">
        <a href="login.php" target="_self">Login</a>
        <a href="logout.php" target="_self">Logout</a>
        <a href="register.php" target="_self">Register</a>
        <a href="map.php" target="_self">Interactive Map</a>
        <a href="create_post.php" target="_self">Create Post</a>
    </div>
    <div id="banner">
	    <h1 title="Frequent Haunts">Frequent Haunts</h1>
        <h2 id="user"></h2>
    </div>
    <br>
    <center>
    <div id="main">
        Take a look at interesting places all over the world! Just make an account, create a post, and it'll appear on the map!<br><br>
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ea eius ab tempore numquam aspernatur doloribus distinctio cupiditate debitis incidunt accusantium fugit quidem autem necessitatibus sed, a molestias at blanditiis optio!
    </div>
    </center>
</body>
</html>

<?php
require_once("db.php");
session_start();

if (isset($_SESSION['userID'])) {
    $query=$db->prepare("SELECT username FROM Users WHERE userID = :user");
    $query->execute(["user"=>$_SESSION["userID"]]);
    $result=$query->fetch();
    echo "<script>writeUsername('" . $result["username"] . "');</script>";
}
?>