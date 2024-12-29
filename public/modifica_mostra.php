<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=modifica_mostra.php");

$database = new DatabaseService();
$modificaMostraContent = Templating::getHtmlWithModifiedMenu(__FILE__);


if (isset($_GET['id_mostra'])) $id_mostra = $_GET['id_mostra'];

$mostraToModifyInfo = $database->selectMostraByID($id_mostra);
$customFormMostra = Templating::getContentBetweenPlaceholders($modificaMostraContent, "customform");

Templating::replaceAnchor($customFormMostra,"id_mostra", $mostraToModifyInfo[0]['id_mostra']);
Templating::replaceAnchor($customFormMostra,"nome_mostra", $mostraToModifyInfo[0]['nome']);
Templating::replaceAnchor($customFormMostra,"descrizione",$mostraToModifyInfo[0]['descrizione']);
Templating::replaceAnchor($customFormMostra,"data_inizio",$mostraToModifyInfo[0]['data_inizio']);
Templating::replaceAnchor($customFormMostra,"data_fine",$mostraToModifyInfo[0]['data_fine']);
Templating::replaceAnchor($customFormMostra,"immagine_mostra",$mostraToModifyInfo[0]['img_path']);

Templating::replaceContentBetweenPlaceholders($modificaMostraContent, "customform", $customFormMostra);

    



Templating::showHtmlPageWithoutPlaceholders($modificaMostraContent);

?>