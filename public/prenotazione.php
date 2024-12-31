<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=prenotazione.php");

if ($_SESSION['is_admin'])
    header("Location: 401.php");

$database = new DatabaseService();
$prenotazioneContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$prenotazioneContent) {}
    //TODO
$errormsgsToModify = Templating::getContentBetweenPlaceholders($prenotazioneContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", "");
Templating::replaceContentBetweenPlaceholders($prenotazioneContent, "errormsgs", $errormsgsToModify);
Templating::showHtmlPageWithoutPlaceholders($prenotazioneContent);

?>