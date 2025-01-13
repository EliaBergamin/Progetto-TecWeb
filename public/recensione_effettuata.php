<?php

require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=recensisci.php");
    exit;
}

$tipo = '';
$data_visita = '';
$rating = '';
$descrizione = '';
$error = [];

if (isset($_POST['submit'])) {

    $data_visita = DatabaseService::cleanedInput($_POST['data_visita']);
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data_visita)) {
        array_push($error, "data_val");
    }
    $today = date("Y-m-d");
    if ($data_visita > $today) {
        array_push($error, "data_fut");
    }

    $rating = DatabaseService::cleanedInput($_POST['rating']);
    if (!preg_match("/^[1-5]$/", $rating)) {
        array_push($error, "rating");
    }

    $descrizione = DatabaseService::cleanedInput($_POST['descrizione']);
    if (strlen($descrizione) < 25 || strlen($descrizione) > 5000) {
        array_push($error, "descr_len");
    } else if (!preg_match("/^[\p{L}\p{P}\p{N}\s\S]+$/u", $descrizione)) {
        array_push($error, "descr_char");
    }

    $tipo = DatabaseService::cleanedInput($_POST['tipo']);
    if (!preg_match("/^[0-1]$/", $tipo)) {
        array_push($error, "tipo");
    }
    if (count($error) > 0) {
        $_SESSION['error'] = $error;
        $_SESSION['rating'] = $rating;
        $_SESSION['data_visita'] = $data_visita;
        $_SESSION['tipo'] = $tipo;
        $_SESSION['descrizione'] = $descrizione;
        header("Location: recensisci.php");
        exit;
    }
    try {
        $database = new DatabaseService();
        $insertSuccess = $database->insertUserReview($_SESSION['user_id'], $rating, $data_visita, $descrizione, $tipo);
        unset($database);
    } catch (Exception $e) {
        unset($database);
        Templating::errCode(500);
    }

    if ($insertSuccess)
        if ($tipo == 0)
            header('Location: recensioni.php');
        else
            header('Location: recensioni.php#titolo-recens-virtual');
    else {
        $_SESSION['error'] = ['insert'];
        $_SESSION['rating'] = $rating;
        $_SESSION['data_visita'] = $data_visita;
        $_SESSION['tipo'] = $tipo;
        $_SESSION['descrizione'] = $descrizione;
        header("Location: recensisci.php");
    }
    exit;
} else 
    Templating::errCode(405);
?>