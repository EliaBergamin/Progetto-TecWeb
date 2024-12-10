<?php
//phpinfo();
try {
    $connection = mysqli_connect("database", "user", "userpassword", "Museo");
} catch (Exception $e) {
    header("Location: 500.html");
    if (mysqli_connect_errno()) {
        file_put_contents('log', $e->getMessage() . "\n" . mysqli_connect_errno() . "\n", FILE_APPEND);        
    }
}
?>