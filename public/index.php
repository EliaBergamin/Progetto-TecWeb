<?php
require_once("phplibs/templatingService.php");

$indexHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
Templating::showHtmlPageWithoutPlaceholders($indexHtmlContent);
?>