<?php
    
    require_once("phplibs/databaseService.php");
    require_once("phplibs/templatingService.php");


    $databaseServiceIstance = new DatabaseService();
    $dettaglioSalaHtmlContent = Templating::getHtmlFileContent(__FILE__);

    $numeroSalaRichiesta = isset($_GET['sala']) ? $_GET['sala'] : 0;

    $arrayOpere = $databaseServiceIstance->selectOpereFromSala(intval($numeroSalaRichiesta));
    $sectionOpereToModify = Templating::getContentBetweenPlaceholders($dettaglioSalaHtmlContent,"opere");

    $fullcontent = "";
    foreach ($arrayOpere as $associativeRow){
        $temp = $sectionOpereToModify;
        Templating::replaceAnchor($temp,"nome_opera",$associativeRow["nome"]);
        Templating::replaceAnchor($temp,"descrizione_opera",$associativeRow["descrizione"]);
        Templating::replaceAnchor($temp,"autore_opera",$associativeRow["autore"]);
        Templating::replaceAnchor($temp,"anno_opera",$associativeRow["anno"]);

        $fullcontent.= $temp . "\n";
    } 

    Templating::replaceContentBetweenPlaceholders($dettaglioSalaHtmlContent,"opere",$fullcontent);

    Templating::showHtmlPageWithoutPlaceholders($dettaglioSalaHtmlContent);


?>