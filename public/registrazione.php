<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (isset($_SESSION['user_id'])) 
    header("Location: index.php?error=already_logged_in");

$database = new DatabaseService();
$registrazioneHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$registrazioneHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($registrazioneHtmlContent);

?>