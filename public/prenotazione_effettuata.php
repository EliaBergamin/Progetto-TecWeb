<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

if (!isset($_SESSION['user_id']))
    header("Location: login.php?redirect=prenotazione.php");

$giorno = '';
$orario = '';
$visitatori = '';
$error = [];

if (isset($_POST['submit'])) {

    $giorno = DatabaseService::cleanedInput($_POST['giorno']);
    if (!preg_match("/\d{4}-\d{2}-\d{2}/", $giorno)) {
        array_push($error, "data_val");
    }
    $today = date("Y-m-d");
    if ($giorno < $today) {
        array_push($error, "data_pass");
    }

    $orario = DatabaseService::cleanedInput($_POST['orario']);
    if (!preg_match("/\d{2}:\d{2}:\d{2}/", $orario)) {
        array_push($error, "orario_val");
    }
    if ($giorno == $today) {
        $currentTime = date("H:i:s");
        if ($orario <= $currentTime) {
            array_push($error, "orario_pass");
        }
    }

    $visitatori = DatabaseService::cleanedInput($_POST['visitatori']);
    if (!preg_match("/\d+/", $visitatori) || $visitatori < 1 || $visitatori > 15) {
        array_push($error, "visitatori_val");
    } else {
        try {
            $database = new DatabaseService();
            $disponibili = $database->checkVisitatori($giorno, $orario, $visitatori);
            unset($database);
        } catch (Exception $e) {
            unset($database);
            Templating::errCode(500);
            exit;
        }
        if (!$disponibili)
            array_push($error, "visitatori_nd");
    }

    if (count($error) > 0) {
        $_SESSION['error'] = $error;
        $_SESSION['giorno'] = $giorno;
        $_SESSION['orario'] = $orario;
        $_SESSION['visitatori'] = $visitatori;
        header("Location: prenotazione.php");
        exit;
    }

    try {
        $database = new DatabaseService();
        $insertSuccess = $database->insertPrenotazione($_SESSION['user_id'], $giorno, $visitatori, $orario);
        unset($database);
    } catch (Exception $e) {
        unset($database);
        Templating::errCode(500);
        exit;
    }
    if ($insertSuccess)
        header('Location: profile.php');
    else {
        $_SESSION['error'] = ['insert'];
        header('Location: prenotazione.php');
    }
    exit;

} else {
    Templating::errCode(405);
    exit;
}

?>