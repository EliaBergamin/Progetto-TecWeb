<?php 

$user = "user";
$pass = "userpassword";
try {
    $dbh = new PDO('mysql:host=database;dbname=museo', $user, $pass);
} catch (PDOException $e) {
    // attempt to retry the connection after some timeout for example
    echo $e;
}


?>