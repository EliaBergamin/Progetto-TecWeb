<?php

require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    $database = new DatabaseService();
    $alterSuccess = $database->deletePrenotazioneUser($_SESSION['user_id'], $_POST['data_prenotazione']);
    unset($database);
} catch (Exception $e) {
    unset($database);
    Templating::errCode(500);
}

header('Location: profile.php');
exit;
?>