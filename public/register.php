<?php 

require_once("phplibs/databaseService.php");

$nome = '';
$cognome = '';
$email = '';
$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $salt = bin2hex(random_bytes(16));
    $password_hash = password_hash($password . $salt, PASSWORD_BCRYPT);
    $database = new DatabaseService();
    // Inserisci il nuovo utente nel database
    $user_id = $database->insertUser(2, $username, $nome, $cognome, $password_hash, $email, $salt);
    unset($database);

    if ($user_id > 0) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = false;
        header("Location: index.php?success=1");
    } else {
        header("Location: registrazione.php?error=1");
    }
}

?>