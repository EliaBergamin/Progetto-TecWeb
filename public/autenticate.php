<?php
require_once("phplibs/databaseService.php");

$redirect = $_GET['redirect'] ?? 'profile.php';

if (isset($_POST['submit'])) {
    $username = DatabaseService::cleanedInput($_POST['username']);
    $password = DatabaseService::cleanedInput($_POST['password']);
    // Consulta per cercare l'utente
    $database = new DatabaseService();
    $users = $database->selectUsersFromUsername($username);
    $user = $users[0] ?? null;
    if (!$user) {
        header("Location: login.php?error=user&redirect=$redirect");
    } elseif (!password_verify($password, $user['password_hash'])) {
        header("Location: login.php?error=pwd&username=$username&redirect=$redirect");   
    } else {
        // Memorizza i dettagli dell'utente nella sessione
        session_start();
        $_SESSION['user_id'] = $user['id_utente'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['ruolo'] === 1; // Memorizza il ruolo
        if (!$_SESSION['is_admin'] || $redirect != 'profile.php')
            header("Location: $redirect");
        else 
            header("Location: admin.php");
    }
    exit;
} else {
    header("Location: login.php");
}
?>