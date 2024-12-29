<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=virtual_tour.php");

$database = new DatabaseService();
$virtualTourHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$virtualTourHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($virtualTourHtmlContent);

?>