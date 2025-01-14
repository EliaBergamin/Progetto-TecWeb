<?php
require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

$indexHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);

$database = new DatabaseService();
$arrayMostreCorrenti = $database->selectMostreCorrenti(false);
if (count($arrayMostreCorrenti) != 3) // < 3
    $arrayMostreFuture= $database->selectMostreFuture(false);
unset($database);

$carosello = Templating::getContentBetweenPlaceholders($indexHtmlContent, "carosello");
for ($i = 0; $i < count($arrayMostreCorrenti); $i++) {
    Templating::replaceAnchor($carosello, "img{$i}", $arrayMostreCorrenti[$i]["img_path"]);
    Templating::replaceAnchor($carosello, "alt{$i}", $arrayMostreCorrenti[$i]["alt"]);
    Templating::replaceAnchor($carosello, "id{$i}", $arrayMostreCorrenti[$i]["id_mostra"]);
}
for ($i = count($arrayMostreCorrenti); $i < 3; $i++) {
    Templating::replaceAnchor($carosello, "img{$i}", $arrayMostreFuture[$i - count($arrayMostreCorrenti)]["img_path"]);
    Templating::replaceAnchor($carosello, "alt{$i}", $arrayMostreFuture[$i - count($arrayMostreCorrenti)]["alt"]);
    Templating::replaceAnchor($carosello, "id{$i}", $arrayMostreFuture[$i - count($arrayMostreCorrenti)]["id_mostra"]);
}
Templating::replaceContentBetweenPlaceholders($indexHtmlContent, "carosello", $carosello);
Templating::showHtmlPageWithoutPlaceholders($indexHtmlContent);
?>