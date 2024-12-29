<?php

    require_once("phplibs/databaseService.php");
    require_once("phplibs/templatingService.php");

    $database = new DatabaseService();
    //user param sarà da rimpiazzare con session user_id implementate le funzionalità di login
    
    $alterSuccess = $database->alterMostraAdmin($_GET['id_mostra'],$_POST['nome-mostra'],$_POST['descrizione-mostra'],$_POST['data-inizio'],$_POST['data-fine'],$_POST['immagine-mostra']);
    
    if($alterSuccess)
        header('Location: /admin.php');
    else
        header('Location: /modifcia_mostra.php?id_mostra='.$_GET['id_mostra']);

?>