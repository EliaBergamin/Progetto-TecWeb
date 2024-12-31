<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id']))
    header("Location: login.php?redirect=modifica_mostra.php");

$aggiungiMostraContent = Templating::getHtmlWithModifiedMenu(__FILE__);

$errormsgsToModify = Templating::getContentBetweenPlaceholders($aggiungiMostraContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", "");
Templating::replaceContentBetweenPlaceholders($aggiungiMostraContent, "errormsgs", $errormsgsToModify);

$formValuesToModify = Templating::getContentBetweenPlaceholders($aggiungiMostraContent, "form");
Templating::replaceAnchor($formValuesToModify, "nome", "");
Templating::replaceAnchor($formValuesToModify, "descrizione", "");
Templating::replaceAnchor($formValuesToModify, "data_inizio", "");
Templating::replaceAnchor($formValuesToModify, "data_fine", "");
Templating::replaceContentBetweenPlaceholders($aggiungiMostraContent, "form", $formValuesToModify);

Templating::showHtmlPageWithoutPlaceholders($aggiungiMostraContent);

?>