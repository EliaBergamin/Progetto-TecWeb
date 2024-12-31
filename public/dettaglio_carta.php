<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=dettaglio_carta.php");

if ($_SESSION['is_admin'])
    header("Location: 401.php");

$database = new DatabaseService();
$dettaglioCartaHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$dettaglioCartaHtmlContent) {} 
    //TODO
Templating::showHtmlPageWithoutPlaceholders($dettaglioCartaHtmlContent);

?>