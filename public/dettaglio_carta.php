<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");


$database = new DatabaseService();
$dettaglioCartaHtmlContent = Templating::getHtmlFileContent(__FILE__);
if (!$dettaglioCartaHtmlContent) {} 
    //TODO
Templating::showHtmlPageWithoutPlaceholders($dettaglioCartaHtmlContent);

?>