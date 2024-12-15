<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");


$database = new DatabaseService();
$recensisciHtmlContent = Templating::getHtmlFileContent(__FILE__);
if (!$recensisciHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($recensisciHtmlContent);

?>