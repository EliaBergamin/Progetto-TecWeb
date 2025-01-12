<?php
require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=dettaglio_opera.php");
    exit;
}

$database = new DatabaseService();
$dettaglioOperaHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);

Templating::showHtmlPageWithoutPlaceholders($dettaglioOperaHtmlContent);

?>