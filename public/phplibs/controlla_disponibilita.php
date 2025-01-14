<?php
require_once("databaseService.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new DatabaseService();

    $giorno = $_POST['giorno'];
    $tutti_gli_slot = ["09:00:00", "10:30:00", "12:00:00", "13:30:00", "15:00:00", "16:30:00"];
    $capienza_massima = 90;

    $posti_occupati = $database->selectPrenotazioniPerData($giorno);
    
    $posti_occupati_normalizzato = [];
    foreach ($posti_occupati as $row) {
        $posti_occupati_normalizzato[$row['slot_orario']] = (int)$row['posti_occupati'];
    }

    $posti_disponibili = [];
    foreach ($tutti_gli_slot as $slot) {
        $posti_occupati = $posti_occupati_normalizzato[$slot] ?? 0;
        $posti_disponibili[$slot] = $capienza_massima - $posti_occupati;
    }

    header('Content-Type: application/json');
    echo json_encode($posti_disponibili);
}
?>
