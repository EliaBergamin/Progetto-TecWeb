<?php
require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

if (isset($_GET['id_mostra']))
    $id_mostra = $_GET['id_mostra'];
else 
    Templating::errCode(404);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=modifica_mostra.php&id_mostra=" . $id_mostra);
    exit;
}

$modificaMostraContent = Templating::getHtmlWithModifiedMenu(__FILE__);

try {
    $database = new DatabaseService();
    $mostraToModifyInfo = $database->selectMostraByID($id_mostra);
    unset($database);
} catch (Exception $e) {
    unset($database);
    Templating::errCode(500);
}

if (empty($mostraToModifyInfo)) 
    Templating::errCode(404);

$messaggiPerForm = '';
if (isset($_SESSION['error']) && is_array($_SESSION['error'])) {
    $error = $_SESSION['error'];
    if (in_array('nome_len', $error))
        $messaggiPerForm .= '<li>Nome troppo corto</li>';
    if (in_array('nome_char', $error))
        $messaggiPerForm .= '<li>Il nome può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    if (in_array('descr_len', $error))
        $messaggiPerForm .= '<li>Descrizione troppo corta</li>';
    if (in_array('descr_char', $error))
        $messaggiPerForm .= '<li>La descrizione può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    if (in_array('data_ini_val', $error))
        $messaggiPerForm .= "<li>Data d'inizio non valida</li>";
    if (in_array('data_fin_val', $error))
        $messaggiPerForm .= "<li>Data di fine non valida</li>";
    if (in_array('data_ini_fin', $error))
        $messaggiPerForm .= "<li>La data di inizio non può essere successiva alla data di fine</li>";
    if (in_array('immagine', $error))
        $messaggiPerForm .= "<li>Immagine non valida</li>";
    if (in_array('modifica', $error))
        $messaggiPerForm .= "<li>Non è stato modificato nulla</li>";
    unset($_SESSION['error']);
}
if (strlen($messaggiPerForm) != 0) 
    $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';

$errormsgsToModify = Templating::getContentBetweenPlaceholders($modificaMostraContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
Templating::replaceContentBetweenPlaceholders($modificaMostraContent, "errormsgs", $errormsgsToModify);


$formValuesToModify = Templating::getContentBetweenPlaceholders($modificaMostraContent, "form");
Templating::replaceAnchor($formValuesToModify, "id_mostra", $id_mostra);
Templating::replaceAnchor($formValuesToModify, "nome", $mostraToModifyInfo[0]['nome']);
Templating::replaceAnchor($formValuesToModify, "descrizione", $mostraToModifyInfo[0]['descrizione']);
Templating::replaceAnchor($formValuesToModify, "data_inizio", $mostraToModifyInfo[0]['data_inizio']);
Templating::replaceAnchor($formValuesToModify, "data_fine", $mostraToModifyInfo[0]['data_fine']);
Templating::replaceAnchor($formValuesToModify, "immagine", $mostraToModifyInfo[0]['img_path']);
Templating::replaceContentBetweenPlaceholders($modificaMostraContent, "form", $formValuesToModify);

Templating::showHtmlPageWithoutPlaceholders($modificaMostraContent);

?>