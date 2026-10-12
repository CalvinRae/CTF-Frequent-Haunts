<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="forms.css">
</head>
<body>
<h2 title="Page Title">Login</h2>
<form action=login.php method="POST">
<label>Username:</label><br>
<input type=text name=username><br>
<label>Password:</label><br>
<input type=password name=password><br>
<button type=submit>Login</button>
</form>
</body>
</html>

<?php
require_once('db.php');

if (isset($_POST['username']) && isset($_POST['password'])){//check if the POST request has been received
    //store post data in variables
	$username=$_POST['username'];
	$password=$_POST['password'];

    //get password hash from db
	$query = $db->prepare("SELECT userID, passwordHash FROM Users WHERE username=:username");
    $query -> execute(["username"=>$username]);
	$result = $query->fetch();

    //check if hashed password matches stored hash, 
    if(password_verify($password,$result['passwordHash'])){
        echo "Successful login";
        session_start();
        $_SESSION['userID']=$result['userID'];
        header('Location: '.$uri.'/index.php');
    }
    else{
        echo "Password incorrect";
    }
}
?>