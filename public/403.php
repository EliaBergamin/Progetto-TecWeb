<?php
require_once "phplibs/templatingService.php";
header('You can\'t access this page', true, 403);
$indexHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
Templating::showHtmlPageWithoutPlaceholders($indexHtmlContent);
?>