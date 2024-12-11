<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");


$database = new DatabaseService();
$registrazioneHtmlContent = Templating::getHtmlFileContent(__FILE__);
if (!$registrazioneHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($registrazioneHtmlContent);

?>