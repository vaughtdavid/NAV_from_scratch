<?php
include("./resources/Db.php");

$_POST["username"] = "david";
$_POST["email"] = "dvgmail";


// Our database object
$db = new Db();    

// Quote and escape form submitted values
$name = $db -> quote($_POST['username']);
$email = $db -> quote($_POST['email']);

// Insert the values into the database
$result = $db -> query("INSERT INTO `users` (`name`,`email`) VALUES (" . $name . "," . $email . ")");


$rows = $db -> select("SELECT `name`,`email` FROM `users`");
print_r($rows);

?>

