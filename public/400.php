<?php
require_once "phplibs/templatingService.php";
header('Bad Request', true, 400);
$indexHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
Templating::showHtmlPageWithoutPlaceholders($indexHtmlContent);
?>