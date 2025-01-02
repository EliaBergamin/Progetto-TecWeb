<?php
require_once("phplibs/databaseService.php");

$database = new DatabaseService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $giorno = $_POST['giorno'];
    $disponibili = [];

    $occupati = $database->selectAvailableSlotsForDate($giorno);
    $tutti_gli_slot = ["09:00", "10:30", "12:00", "13:30", "15:00", "16:30"];

    foreach ($tutti_gli_slot as $slot) {
        if (!in_array($slot, $occupati)) {
            $disponibili[] = $slot;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($disponibili);
}
?>
