<?php
    
    require_once("phplibs/databaseService.php");
    require_once("phplibs/templatingService.php");


    $databaseServiceIstance = new DatabaseService();
    $recensioniHtmlContent = Templating::getHtmlFileContent(__FILE__);

    /* RECENSIONI MUSEO*/
    $arrayRecensioniMuseo = $databaseServiceIstance->selectRecensioniWithType(0);
    $sectionRecensioniMuseoToModify = Templating::getContentBetweenPlaceholders($recensioniHtmlContent,"recensionimuseo");

    $fullcontent = "";
    foreach ($arrayRecensioniMuseo as $associativeRow){
        $temp = $sectionRecensioniMuseoToModify;
        Templating::replaceAnchor($temp,"nome_utente",$associativeRow["username"]);
        Templating::replaceAnchor($temp,"voto_recensione",$associativeRow["voto"]);
        Templating::replaceAnchor($temp,"svg_dynamic_generation",
                                Templating::generateSvgFromScore($associativeRow["voto"]));
        Templating::replaceAnchor($temp, "data_recensione",$associativeRow["data_recensione"]);
        Templating::replaceAnchor($temp, "string_data_recensione",
                                Templating::convertDateTimeToString($associativeRow["data_recensione"]));
        Templating::replaceAnchor($temp,"descrizione_recensione",$associativeRow["descrizione"]);

        $fullcontent.= $temp . "\n";
    } 
    
    Templating::replaceContentBetweenPlaceholders($recensioniHtmlContent,"recensionimuseo",$fullcontent);

    /* RECENSIONI VIRTUAL TOUR */

    $arrayRecensioniVirtualTour = $databaseServiceIstance->selectRecensioniWithType(1);
    $sectionRecensioniVirtualTourToModify = Templating::getContentBetweenPlaceholders($recensioniHtmlContent,"recensionivirtualtour");

    $fullcontent = "";
    foreach ($arrayRecensioniVirtualTour as $associativeRow){
        $temp = $sectionRecensioniVirtualTourToModify;
        Templating::replaceAnchor($temp,"nome_utente",$associativeRow["username"]);
        Templating::replaceAnchor($temp,"voto_recensione",$associativeRow["voto"]);
        Templating::replaceAnchor($temp,"svg_dynamic_generation",
                                Templating::generateSvgFromScore($associativeRow["voto"]));
        Templating::replaceAnchor($temp, "data_recensione",$associativeRow["data_recensione"]);
        Templating::replaceAnchor($temp, "string_data_recensione",
                                Templating::convertDateTimeToString($associativeRow["data_recensione"]));
        Templating::replaceAnchor($temp,"descrizione_recensione",$associativeRow["descrizione"]);

        $fullcontent.= $temp . "\n";
    } 

    Templating::replaceContentBetweenPlaceholders($recensioniHtmlContent,"recensionivirtualtour",$fullcontent);


    Templating::showHtmlPageWithoutPlaceholders($recensioniHtmlContent);