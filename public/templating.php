<?php 
require_once("databaseConnection.php");

class Templating {
    
    public static function execQuery($queryString ){
        global $dbh;
        $result = $dbh->query($queryString);
        $results = $result->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }


    public static function insertTemplateHTML($pathToHTML,$phpContent){
        // Leggi il contenuto del file HTML
        $template = file_get_contents($pathToHTML);
        
        // Sostituisci i commenti con il contenuto PHP

        $start = strpos($template, "<!-- Prova -->");
        $end = strpos($template, "<!-- Fine Prova -->");

        // Se entrambi i commenti sono presenti
        if ($start !== false && $end !== false) {
            // Inserisci il contenuto PHP tra i due commenti
            $template = substr_replace($template, $phpContent, $start + strlen('<!-- Prova -->'), $end - $start - strlen('<!-- Prova -->'));
        }
     
        file_put_contents($pathToHTML, $template);
    }

    public static function formattaDataIta($data) {
        // Crea un oggetto DateTime dalla stringa data nel formato 'yyyy-mm-dd'
        $date = DateTime::createFromFormat('Y-m-d', $data);
        
        // Mesi in italiano (mappatura dei mesi da inglese a italiano)
        $mesi = [
            "January" => "Gennaio", "February" => "Febbraio", "March" => "Marzo", "April" => "Aprile",
            "May" => "Maggio", "June" => "Giugno", "July" => "Luglio", "August" => "Agosto",
            "September" => "Settembre", "October" => "Ottobre", "November" => "Novembre", "December" => "Dicembre"
        ];
        
        // Verifica se la data è valida
        if ($date) {
            // Ottieni il nome del mese in inglese
            $meseInglese = $date->format('F');
            
            // Converte il mese in italiano utilizzando l'array di mappatura
            $meseItaliano = isset($mesi[$meseInglese]) ? $mesi[$meseInglese] : $meseInglese;
            
            // Ritorna la data nel formato 'dd Mese Anno' con il mese in italiano
            return $date->format('d') . ' ' . $meseItaliano . ' ' . $date->format('Y');
        } else {
            return "Data non valida";
        }
    }
}



?>