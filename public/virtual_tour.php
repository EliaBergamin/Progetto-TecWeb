<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=virtual_tour.php");
    exit;
}

$database = new DatabaseService();
$virtualTourHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);

Templating::showHtmlPageWithoutPlaceholders($virtualTourHtmlContent);

?>