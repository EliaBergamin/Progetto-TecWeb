<?php
require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

$numeroSalaRichiesta = isset($_GET['sala']) ? $_GET['sala'] : Templating::errCode(404);
$operaIdRichiesta = isset($_GET['id_opera']) ? $_GET['id_opera'] : Templating::errCode(404);

if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=dettaglio_opera.php?sala=$numeroSalaRichiesta");

$dettaglioOperaHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);

/* BREADCRUMB SALA*/

$sectionBreadcrumbToModify = Templating::getContentBetweenPlaceholders($dettaglioOperaHtmlContent, "numerosalabread");
Templating::replaceAnchor($sectionBreadcrumbToModify,"numero_sala_bread",$numeroSalaRichiesta);
Templating::replaceAnchor($sectionBreadcrumbToModify,"numero_sala",$numeroSalaRichiesta);
Templating::replaceContentBetweenPlaceholders($dettaglioOperaHtmlContent, "numerosalabread", $sectionBreadcrumbToModify);

$database = new DatabaseService();
$operaArrayDetailed = $database->selectOperaInfoFromId($operaIdRichiesta);
unset($database);

if (empty($operaArrayDetailed)) 
    Templating::errCode(404);
 
//titoloh1
$sectionh1ToModify = Templating::getContentBetweenPlaceholders($dettaglioOperaHtmlContent,"operah1");
Templating::replaceAnchor($sectionh1ToModify,"opera_name_h1",$operaArrayDetailed[0]["nome"]);
Templating::replaceContentBetweenPlaceholders($dettaglioOperaHtmlContent, "operah1", $sectionh1ToModify);

//immagine path
$imageSectionToModify = Templating::getContentBetweenPlaceholders($dettaglioOperaHtmlContent,"operaimage");
Templating::replaceAnchor($imageSectionToModify,"operaimage",$operaArrayDetailed[0]["img_path"]);
Templating::replaceContentBetweenPlaceholders($dettaglioOperaHtmlContent, "operaimage", $imageSectionToModify);

//descrizione opera
$descriptionSectionToModify = Templating::getContentBetweenPlaceholders($dettaglioOperaHtmlContent,"operadescription");
Templating::replaceAnchor($descriptionSectionToModify,"operadescription",$operaArrayDetailed[0]["descrizione"]);
Templating::replaceContentBetweenPlaceholders($dettaglioOperaHtmlContent, "operadescription", $descriptionSectionToModify);
//dettagli opera
$detailsSectionToModify = Templating::getContentBetweenPlaceholders($dettaglioOperaHtmlContent,"operadetails");
Templating::replaceAnchor($detailsSectionToModify,"nome",$operaArrayDetailed[0]["nome"]);
Templating::replaceAnchor($detailsSectionToModify,"operayear",$operaArrayDetailed[0]["anno"]);
Templating::replaceAnchor($detailsSectionToModify,"operaauthor",$operaArrayDetailed[0]["autore"]);
Templating::replaceContentBetweenPlaceholders($dettaglioOperaHtmlContent, "operadetails", $detailsSectionToModify);


Templating::showHtmlPageWithoutPlaceholders($dettaglioOperaHtmlContent);
?>