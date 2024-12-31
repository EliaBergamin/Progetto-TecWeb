<?php

    require_once("phplibs/databaseService.php");
    require_once("phplibs/templatingService.php");

    $database = new DatabaseService();
    //user param sarà da rimpiazzare con session user_id implementate le funzionalità di login
    $insertSuccess = $database->insertPrenotazione($_SESSION['user_id'],$_POST['giorno'],intval($_POST['visitatori']),$_POST['orario']);

    //TODO redirect alla home page  header("Location: /"); 
    if($insertSuccess)
        header('Location: /profile.php');
    else
        header('Location: /prenotazione.php');

?>