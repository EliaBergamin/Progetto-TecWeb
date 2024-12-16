<?php
require_once("phplibs/templatingService.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$indexHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
Templating::showHtmlPageWithoutPlaceholders($indexHtmlContent);
?>