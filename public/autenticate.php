<?php
require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

$redirect = $_GET['redirect'] ?? 'profile.php';

if (isset($_POST['submit'])) {
    $username = DatabaseService::cleanedInput($_POST['username']);
    if (!preg_match("/^[A-Za-z0-9]{4,20}$/u", $username)) {
        $_SESSION["error"] = "user";
        header("Location: login.php?redirect=$redirect");
        exit;
    }

    try {
        $database = new DatabaseService();
        $users = $database->selectUsersFromUsername($username);
        unset($database);
    } catch (Exception $e) {
        unset($database);
        Templating::errCode(500);
    }

    $user = $users[0] ?? null;
    if (!$user) {
        $_SESSION["error"] = "user";
        $_SESSION["username"] = $username;
        header("Location: login.php?redirect=$redirect");
        exit;
    } 

    $password = DatabaseService::cleanedInput($_POST['password']);
    
    if (strlen($password) < 4 || !password_verify($password, $user['password_hash'])) {
        $_SESSION["error"] = "pwd";
        $_SESSION["username"] = $username;
        header("Location: login.php?redirect=$redirect");   
    } else {
        // Memorizza i dettagli dell'utente nella sessione
        $_SESSION['user_id'] = $user['id_utente'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['ruolo'] === 1; // Memorizza il ruolo
        if (!$_SESSION['is_admin'] || $redirect != 'profile.php')
            header("Location: $redirect");
        else 
            header("Location: admin.php");
    }
    exit;
} else 
    Templating::errCode(400);
?>