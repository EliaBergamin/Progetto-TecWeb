<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=prenotazione.php");

$database = new DatabaseService();
$prenotazioneHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$prenotazioneHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($prenotazioneHtmlContent);

?>