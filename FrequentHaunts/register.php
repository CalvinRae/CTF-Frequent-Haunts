<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
	<link rel="stylesheet" href="forms.css">
</head>
<body>
<h2 title="Page Title">Register</h2>
<form action=register.php method="POST">
<label>Username:</label><br>
<input type=text name=username><br>
<label>Password:</label><br>
<input type=password name=password><br>
<button type=submit>Register</button>
</form>
</body>
</html>

<?php
require_once('db.php');

if (isset($_POST['username']) && isset($_POST['password'])){//check if POST for registration was received
    //store POST variables in new variables, and hash the password
	$username=$_POST['username'];
	$hashed_pass=password_hash($_POST['password'], PASSWORD_ARGON2ID);

    //get all usernames
	$query = "SELECT username FROM Users";
	$result = $db->query($query);

    //iterate through usernames in the database, check if the username from POST matches any of them
	$username_is_unique=True;
	foreach ($result as $existing_name) {
		if ($username==$existing_name['username']) {
			$username_is_unique=False;
		}
	}

	if ($username_is_unique==False){
		echo "That username is taken";
	}
	else {
        //add new user details to the database
		$query=$db->prepare("INSERT INTO Users (username, passwordHash) VALUES (:uname, :hpass)");
		$query->execute([
			"uname" => $username,
			"hpass" => $hashed_pass
		]);
		echo "Registration successful";
		session_start();
		$query = $db->prepare("SELECT userID FROM Users WHERE username=:username");
    	$query -> execute(["username"=>$username]);
		$result = $query->fetch();
        $_SESSION['userID']=$result['userID'];
        header('Location: '.$uri.'/index.php');
	}
}
?>