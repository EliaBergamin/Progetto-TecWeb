<?php
require_once("phplibs/templatingService.php");
header('This is not the page you are looking for', true, 500);
$indexHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
Templating::showHtmlPageWithoutPlaceholders($indexHtmlContent);
?>