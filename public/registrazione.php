<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

session_start();

if (isset($_SESSION['user_id'])) 
    header("Location: index.php");

$database = new DatabaseService();
$registrazioneHtmlContent = Templating::getHtmlFileContent(__FILE__);
if (!$registrazioneHtmlContent) {}
    //TODO
Templating::showHtmlPageWithoutPlaceholders($registrazioneHtmlContent);

?>