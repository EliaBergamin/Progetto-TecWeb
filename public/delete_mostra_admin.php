<?php

require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if (!$_SESSION['is_admin'])
    Templating::errCode(403);

try {
    $database = new DatabaseService();
    $alterSuccess = $database->deleteMostraAdmin($_POST['id_mostra']);
    unset($database);
} catch (Exception $e) {
    unset($database);
    Templating::errCode(500);
}

header('Location: /admin.php');
exit;
?>