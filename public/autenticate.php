<?php
require_once("phplibs/databaseService.php");

$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Consulta per cercare l'utente
    $database = new DatabaseService();
    $users = $database->selectUsersFromUsername($username);
    $user = $users[0] ?? null;
    if (!$user) {
        header("Location: login.php?error=user");
    } elseif (!password_verify($password, $user['password_hash'])) {
        header("Location: login.php?error=pwd");   
    } else {
        // Memorizza i dettagli dell'utente nella sessione
        session_start();
        $_SESSION['user_id'] = $user['id_utente'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['ruolo'] === 1; // Memorizza il ruolo
        header("Location: $redirect");
    }
    exit;
} else {
    header("Location: login.php?redirect=$redirect");
}
?>