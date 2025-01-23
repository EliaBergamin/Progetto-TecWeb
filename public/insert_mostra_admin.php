<?php

require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=aggiungi_mostra.php");
    exit;
}
if (!$_SESSION['is_admin']) 
    Templating::errCode(403);

$nome = '';
$descrizione = '';
$data_inizio = '';
$data_fine = '';
$immagine = '';
$error = [];

if (isset($_POST['submit'])) {

    $nome = DatabaseService::cleanedInput($_POST['nome']);

    if (strlen($nome) < 2 || strlen($nome) > 80) {
        array_push($error, 'nome_len');
    } else if (!preg_match("/^[\p{L}\p{P}\p{N}\ \/=<>]+$/u", $nome)) {
        array_push($error, 'nome_char');
    }

    $descrizione = DatabaseService::cleanedInput($_POST['descrizione']);
    if (strlen($descrizione) < 25 || strlen($descrizione) > 5000) {
        array_push($error, 'descr_len');
    } else if (!preg_match("/^[\p{L}\p{P}\p{N}\s\S\/=<>]+$/u", $descrizione)) {
        array_push($error, 'descr_char');
    }

    $data_inizio = DatabaseService::cleanedInput($_POST['data_inizio']);
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_inizio)) {
        array_push($error, 'data_ini_val');
    }
    $data_fine = DatabaseService::cleanedInput($_POST['data_fine']);
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_fine)) {
        array_push($error, 'data_fin_val');
    } else if (strtotime($data_inizio) > strtotime($data_fine)) {
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
        $_SESSION['nome'] = $nome;
        $_SESSION['descrizione'] = $descrizione;
        $_SESSION['data_inizio'] = $data_inizio;
        $_SESSION['data_fine'] = $data_fine;
        header("Location: aggiungi_mostra.php");
        exit;
    }

    try {
        $database = new DatabaseService();
        $insertSuccess = $database->insertMostra($nome, $descrizione, $data_inizio, $data_fine, $immagine);
        unset($database);
    } catch (Exception $e) {
        unset($database);
        Templating::errCode(500);
    }
    if ($insertSuccess)
        header('Location: admin.php');
    else {
        $_SESSION['error'] = ['insert'];
        $_SESSION['nome'] = $nome;
        $_SESSION['descrizione'] = $descrizione;
        $_SESSION['data_inizio'] = $data_inizio;
        $_SESSION['data_fine'] = $data_fine;
        header('Location: aggiungi_mostra.php');
    }
    exit;
} else 
    Templating::errCode(400);
?>