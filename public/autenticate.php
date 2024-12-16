<?php
session_start();
require_once("phplibs/databaseService.php");

$database = new DatabaseService();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Consulta per cercare l'utente
    $user = $database->selectUserFromUsername($username);

    if ($user && password_verify($password, $user['password'])) {
        // Memorizza i dettagli dell'utente nella sessione
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['role'] === 1; // Memorizza il ruolo
        header("Location: index.php");
        exit;
    } else {
        header("Location: login.php?error=1");
    }
}
?>