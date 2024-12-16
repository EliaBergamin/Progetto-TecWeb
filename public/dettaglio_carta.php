<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

session_start();

if (!isset($_SESSION['user_id'])) 
    header("Location: login.php");

$database = new DatabaseService();
$dettaglioCartaHtmlContent = Templating::getHtmlFileContent(__FILE__);
if (!$dettaglioCartaHtmlContent) {} 
    //TODO
Templating::showHtmlPageWithoutPlaceholders($dettaglioCartaHtmlContent);

?>