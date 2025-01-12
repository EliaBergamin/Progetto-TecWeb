<?php

require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

if (isset($_GET['id_mostra']))
    $id_mostra = $_GET['id_mostra'];
else 
    Templating::errCode(404);

$nome = '';
$descrizione = '';
$data_inizio = '';
$data_fine = '';
$immagine = '';
$error = [];

if (isset($_POST['submit'])) {

    $nome = DatabaseService::cleanedInput($_POST['nome']);
    if (strlen($nome) < 2) {
        array_push($error, 'nome_len');
    } else if (!preg_match("/^[\p{L}\p{P}\p{N}\ ]+$/u", $nome)) {
        array_push($error, 'nome_char');
    }

    $descrizione = DatabaseService::cleanedInput($_POST['descrizione']);
    if (strlen($descrizione) < 25) {
        array_push($error, 'descr_len');
    } else if (!preg_match("/^[\p{L}\p{P}\p{N}\s\S]+$/u", $descrizione)) {
        array_push($error, 'descr_char');
    }

    $data_inizio = DatabaseService::cleanedInput($_POST['data_inizio']);
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_inizio)) {
        array_push($error, 'data_ini_val');
    }
    $data_fine = DatabaseService::cleanedInput($_POST['data_fine']);
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_fine)) {
        array_push($error, 'data_fin_val');
    }

    if (strtotime($data_inizio) > strtotime($data_fine)) {
        array_push($error, 'data_ini_fin');
    }
    
    if ($_FILES["immagine"]["tmp_name"]) {
        $upload = Templating::uploadImg($_FILES["immagine"]);
        if ($upload[0]) 
            $immagine = $upload[1];
        else 
            array_push($error, $upload[1]);
    }
    else 
        array_push($error, 'upload', 'size');

    if (count($error) > 0) {
        $_SESSION['error'] = $error;
        header("Location: modifica_mostra.php?id_mostra=$id_mostra");
        exit;
    }
    try {
        $database = new DatabaseService();
        $alterSuccess = $database->alterMostraAdmin($id_mostra, $nome, $descrizione, $data_inizio, $data_fine, $immagine);
        unset($database);
    } catch (Exception $e) {
        unset($database);
        Templating::errCode(500);
    }
    if ($alterSuccess) {
        $_SESSION["success"] = ["Modifica effettuata con successo"];
        header('Location: admin.php');
    } else {
        $_SESSION['error'] = ['modifica'];
        header("Location: modifica_mostra.php?id_mostra=$id_mostra");
    }
    exit;
} else 
    Templating::errCode(405);
?>