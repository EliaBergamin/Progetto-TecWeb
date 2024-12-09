<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");


$databaseServiceIstance = new DatabaseService();
$dettaglioCartaHtmlContent = Templating::getHtmlFileContent(__FILE__);
Templating::showHtmlPageWithoutPlaceholders($dettaglioCartaHtmlContent);

?>