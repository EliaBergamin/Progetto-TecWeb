<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");


$database = new DatabaseService();
$virtualTourHtmlContent = Templating::getHtmlFileContent(__FILE__);
if (!$virtualTourHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($virtualTourHtmlContent);

?>