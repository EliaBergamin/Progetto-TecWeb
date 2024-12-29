<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=modifica_mostra.php");

$database = new DatabaseService();
$modificaMostraContent = Templating::getHtmlWithModifiedMenu(__FILE__);

Templating::showHtmlPageWithoutPlaceholders($modificaMostraContent);

?>