<?php

    require_once("phplibs/databaseService.php");
    require_once("phplibs/templatingService.php");

    $database = new DatabaseService();
    //user param sarà da rimpiazzare con session user_id implementate le funzionalità di login
    
    $insertSuccess = $database->insertMostraAdmin($_POST['nome-mostra'],$_POST['descrizione-mostra'],$_POST['data-inizio'],$_POST['data-fine'],$_POST['immagine-mostra']);
    
    if($insertSuccess)
        header('Location: /admin.php');
    else
        header('Location: /aggiungi_mostra.php');

?>