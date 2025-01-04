<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

$redirect = $_GET['redirect'] ?? 'index.php';

$nome = '';
$cognome = '';
$email = '';
$username = '';
$password = '';
$error = [];

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = DatabaseService::cleanedInput($_POST['nome']);
    if (strlen($nome) < 2) {
        array_push($error, 'nome_len');
    } else if (!preg_match("/[\p{L}\p{P}\p{N}\ ]+/u", $nome)) {
        array_push($error, 'nome_char');
    }

    $cognome = DatabaseService::cleanedInput($_POST['cognome']);
    if (strlen($cognome) < 2) {
        array_push($error, 'cognome_len');
    } else if (!preg_match("/[\p{L}\p{P}\p{N}\ ]+/u", $cognome)) {
        array_push($error, 'cognome_char');
    }

    $email = DatabaseService::cleanedInput($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($error, 'email_val');
    } else {
        try {
            $database = new DatabaseService();
            $users = $database->selectUsersFromUsername($username);
            unset($database);
        } catch (Exception $e) {
            unset($database);
            Templating::errCode(500);
            exit;
        }
        if (count($users) > 0) {
            array_push($error, 'email_exists');
        }
    }

    $username = DatabaseService::cleanedInput($_POST['username']);
    if (strlen($username) < 4) {
        array_push($error, 'username_len');
    } else if (!preg_match("/[\p{L}\p{N}]+/u", $username)) {
        array_push($error, 'username_char');
    } else {
        try {
            $database = new DatabaseService();
            $users = $database->selectUsersFromUsername($username);
            unset($database);
        } catch (Exception $e) {
            unset($database);
            Templating::errCode(500);
            exit;
        }
        if (count($users) > 0) {
            array_push($error, 'username_exists');
        }
    }
    $password = DatabaseService::cleanedInput($_POST['password']);
    if (strlen($password) < 4) {
        array_push($error, 'password_len');
    }

    if (count($error) > 0) {
        $_SESSION['error'] = $error;
        $_SESSION['nome'] = $nome;
        $_SESSION['cognome'] = $cognome;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        header("Location: registrazione.php?redirect=$redirect");
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    try {
        $database = new DatabaseService();
        // Inserisci il nuovo utente nel database
        $user_id = $database->insertUser(2, $username, $nome, $cognome, $password_hash, $email);
        unset($database);
    } catch (Exception $e) {
        unset($database);
        Templating::errCode(500);
        exit;
    }

    if ($user_id > 0) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = false;
        $_SESSION['success'] = ['Registrazione avvenuta con successo'];
        header("Location: $redirect");
    } else {
        $_SESSION['error'] = ['insert'];
        header("Location: registrazione.php?redirect=$redirect");
    }
} else {
    Templating::errCode(405);
    exit;
}

?>