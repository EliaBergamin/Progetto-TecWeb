<?php

    require_once("phplibs/databaseService.php");
    require_once("phplibs/templatingService.php");
    
    $database = new DatabaseService();
    //user param sarà da rimpiazzare con session user_id implementate le funzionalità di login
    
    $alterSuccess = $database->deletePrenotazioneUser($_SESSION['user_id'],$_POST['data_prenotazione']);
    
    if($alterSuccess)
        header('Location: /profile.php');
    else
        header('Location: /index.php');

?>