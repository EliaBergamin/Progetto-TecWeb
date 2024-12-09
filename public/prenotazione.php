<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");


$databaseServiceIstance = new DatabaseService();
$prenotazioneHtmlContent = Templating::getHtmlFileContent(__FILE__);
Templating::showHtmlPageWithoutPlaceholders($prenotazioneHtmlContent);

?>