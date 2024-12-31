<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (isset($_SESSION['user_id']))
    header("Location: index.php?error=logged");

$database = new DatabaseService();
$registrazioneHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$registrazioneHtmlContent) {
}
//TODO
$errormsgsToModify = Templating::getContentBetweenPlaceholders($prenotazioneContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", "");
Templating::replaceContentBetweenPlaceholders($prenotazioneContent, "errormsgs", $errormsgsToModify);
$formValuesToModify = Templating::getContentBetweenPlaceholders($registrazioneHtmlContent, "form");
Templating::replaceAnchor($formValuesToModify, "nome", "");
Templating::replaceAnchor($formValuesToModify, "cognome", "");
Templating::replaceAnchor($formValuesToModify, "username", "");
Templating::replaceAnchor($formValuesToModify, "email", "");
Templating::replaceContentBetweenPlaceholders($registrazioneHtmlContent, "form", $formValuesToModify);
Templating::showHtmlPageWithoutPlaceholders($registrazioneHtmlContent);

?>