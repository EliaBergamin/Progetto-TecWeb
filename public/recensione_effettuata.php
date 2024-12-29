<?php

    require_once("phplibs/databaseService.php");
    require_once("phplibs/templatingService.php");

    $database = new DatabaseService();
    //user param sarà da rimpiazzare con session user_id implementate le funzionalità di login
    $insertSuccess = $database->insertUserReview($_SESSION['user_id'],intval($_POST['rating']),$_POST['data-visita'],$_POST['descrizione'],intval($_POST['tipo']));
    
    if($insertSuccess)
        header('Location: /profile.php');
    else
        header('Location: /recensisci.php');

?>