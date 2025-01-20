<?php
require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

$indexHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);

$database = new DatabaseService();
$arrayMostreCorrenti = $database->selectMostreCorrenti(false);
$arrayMostreFuture= $database->selectMostreFuture(false);
$arrayMostrePassate = $database->selectMostrePassate(false);
unset($database);

$defaultCarouselArray = [
    [
        "id_mostra" => -1,
        "nome" => "Il primo museo virtuale sui cartoni animati",
        "img_path" => "../images/car1.webp",
        "alt" => ""
    ],
    [
        "id_mostra" => -2,
        "nome" => "Il primo museo virtuale sui cartoni animati",
        "img_path" => "../images/car2.webp",
        "alt" => ""
    ],
    [
        "id_mostra" => -3,
        "nome" => "Il primo museo virtuale sui cartoni animati",
        "img_path" => "../images/car3.webp",
        "alt" => ""
    ]
];
$arrayMostreMerged = array_merge($arrayMostreCorrenti, $arrayMostreFuture, $arrayMostrePassate);
$arrayMostreMerged = count($arrayMostreMerged) < 3 ? array_merge($arrayMostreMerged, $defaultCarouselArray) : $arrayMostreMerged;
$carosello = Templating::getContentBetweenPlaceholders($indexHtmlContent, "carosello");
for ($i = 0; $i < 3; $i++) {
    Templating::replaceAnchor($carosello, "nome{$i}", $arrayMostreMerged[$i]["nome"]);
    Templating::replaceAnchor($carosello, "img{$i}", $arrayMostreMerged[$i]["img_path"]);
    Templating::replaceAnchor($carosello, "alt{$i}", $arrayMostreMerged[$i]["alt"]);
    Templating::replaceAnchor($carosello, "id{$i}", $arrayMostreMerged[$i]["id_mostra"]);
}
// for ($i = 0; $i < count($arrayMostreCorrenti); $i++) {
//     Templating::replaceAnchor($carosello, "img{$i}", $arrayMostreCorrenti[$i]["img_path"]);
//     Templating::replaceAnchor($carosello, "alt{$i}", $arrayMostreCorrenti[$i]["alt"]);
//     Templating::replaceAnchor($carosello, "id{$i}", $arrayMostreCorrenti[$i]["id_mostra"]);
// }
// for ($i = count($arrayMostreCorrenti); $i < 3; $i++) {
//     Templating::replaceAnchor($carosello, "img{$i}", $arrayMostreFuture[$i - count($arrayMostreCorrenti)]["img_path"]);
//     Templating::replaceAnchor($carosello, "alt{$i}", $arrayMostreFuture[$i - count($arrayMostreCorrenti)]["alt"]);
//     Templating::replaceAnchor($carosello, "id{$i}", $arrayMostreFuture[$i - count($arrayMostreCorrenti)]["id_mostra"]);
// }

Templating::replaceContentBetweenPlaceholders($indexHtmlContent, "carosello", $carosello);
Templating::showHtmlPageWithoutPlaceholders($indexHtmlContent);
?>