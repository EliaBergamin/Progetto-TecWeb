<?php

    require_once("phplibs/databaseService.php");

    $database = new DatabaseService();
    //user param sarà da rimpiazzare con session user_id implementate le funzionalità di login
    $insertSuccess = $database->insertUserPrenotazione(1,$_POST['giorno'],intval($_POST['visitatori']),$_POST['orario']);

    //TODO redirect alla home page  header("Location: /"); 
    if($insertSuccess)
        header('Location: /index.php');
    else
        header('Location: /prenotazione.php');

?>