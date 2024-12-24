<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=recensisci.php");

$database = new DatabaseService();
$recensisciHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$recensisciHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($recensisciHtmlContent);

?>