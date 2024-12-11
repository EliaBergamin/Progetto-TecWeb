<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");


$database = new DatabaseService();
$prenotazioneHtmlContent = Templating::getHtmlFileContent(__FILE__);
if (!$prenotazioneHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($prenotazioneHtmlContent);

?>