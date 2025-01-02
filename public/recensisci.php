<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

if (!isset($_SESSION['user_id']))
    header("Location: login.php?redirect=recensisci.php");

$database = new DatabaseService();
$recensisciContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$recensisciContent) {
}
//TODO

$recensisciContent = Templating::getHtmlWithModifiedMenu("recensisci.php");
$errormsgsToModify = Templating::getContentBetweenPlaceholders($recensisciContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", '');
Templating::replaceContentBetweenPlaceholders($recensisciContent, "errormsgs", $errormsgsToModify);

$formValuesToModify = Templating::getContentBetweenPlaceholders($recensisciContent, "form");
Templating::replaceAnchor($formValuesToModify, "r1", '');
Templating::replaceAnchor($formValuesToModify, "r2", '');
Templating::replaceAnchor($formValuesToModify, "r3", '');
Templating::replaceAnchor($formValuesToModify, "r4", '');
Templating::replaceAnchor($formValuesToModify, "r5", '');
Templating::replaceAnchor($formValuesToModify, "data_visita", '');
Templating::replaceAnchor($formValuesToModify, "checkedMuseo", '');
Templating::replaceAnchor($formValuesToModify, "checkedVirtual", '');
Templating::replaceAnchor($formValuesToModify, "descrizione", '');
Templating::replaceContentBetweenPlaceholders($recensisciContent, "form", $formValuesToModify);
Templating::showHtmlPageWithoutPlaceholders($recensisciContent);

?>