<?php
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (array_key_exists("email", $_POST))
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    if (array_key_exists("password", $_POST))
        $password = clean_input($_POST["password"]);

    include "connect.php";

    $stmt = $connection->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bind_param(':username', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // password valida
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        echo "Credenziali incorrette";
    }
}
?>