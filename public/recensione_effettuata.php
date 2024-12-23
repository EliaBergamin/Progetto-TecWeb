<?php

    require_once("phplibs/databaseService.php");

    $database = new DatabaseService();
    //user param sarà da rimpiazzare con session user_id implementate le funzionalità di login
    $database->insertUserReview(1,intval($_POST['rating']),$_POST['data-visita'],$_POST['descrizione'],intval($_POST['tipo']));
    
    header("Location: /recensioni.php");

?>