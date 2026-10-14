<?php
$host="db:3306";
$username="root";
$pass=getenv("db_root_password");
$dbname="FrequentHaunts";


if(!isset($db)){
	$db = new PDO("mysql:host=$host;dbname=$dbname",$username,$pass);
}
?>