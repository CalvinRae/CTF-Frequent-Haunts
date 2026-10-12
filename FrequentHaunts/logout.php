<?php
session_start();
session_destroy();
echo("Logged out, redirecting");
header('Location: '.$uri.'/index.php');
?>