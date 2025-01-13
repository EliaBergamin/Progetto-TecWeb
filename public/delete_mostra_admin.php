<?php

require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

$database = new DatabaseService();
//user param sarà da rimpiazzare con session user_id implementate le funzionalità di login

$alterSuccess = $database->deleteMostraAdmin($_POST['id_mostra']);

if ($alterSuccess)
    header('Location: /admin.php');
else
    header('Location: /admin.php');
exit;
?>