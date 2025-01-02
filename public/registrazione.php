<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (isset($_SESSION['user_id']))
    header("Location: index.php?error=logged");

$database = new DatabaseService();
$registrazioneContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$registrazioneContent) {
}
//TODO
$errormsgsToModify = Templating::getContentBetweenPlaceholders($registrazioneContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", "");
Templating::replaceContentBetweenPlaceholders($registrazioneContent, "errormsgs", $errormsgsToModify);

$formValuesToModify = Templating::getContentBetweenPlaceholders($registrazioneContent, "form");
Templating::replaceAnchor($formValuesToModify, "nome", "");
Templating::replaceAnchor($formValuesToModify, "cognome", "");
Templating::replaceAnchor($formValuesToModify, "username", "");
Templating::replaceAnchor($formValuesToModify, "email", "");
Templating::replaceContentBetweenPlaceholders($registrazioneContent, "form", $formValuesToModify);

Templating::showHtmlPageWithoutPlaceholders($registrazioneContent);

?>