<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

$redirect = $_GET['redirect'] ?? 'index.php';
if (isset($_SESSION['user_id']))
    header("Location: $redirect");

$database = new DatabaseService();
$loginHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$loginHtmlContent) {
}
//TODO
$formToModify = Templating::getContentBetweenPlaceholders($loginHtmlContent, 'form');
Templating::replaceAnchor($formToModify, 'redirect', $redirect);
Templating::replaceContentBetweenPlaceholders($loginHtmlContent, 'form', $formToModify);
Templating::showHtmlPageWithoutPlaceholders($loginHtmlContent);

?>