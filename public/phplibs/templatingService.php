<?php

#Esplichiamo per bene il processo di templating (con la nostra implementazione) 
// Partendo da una pagina html che suddivide le varie sezioni dinamiche con nomi 
// del tipo <!-- nome_sezione_start --> e <!--nome_sezione_end -->, l'obiettivo è sosituire 
// il codice html all'interno con i dati dinamici prelevati dal db. Tra questi due tag sarà 
// presente il codice html di quella sezione con al posto dei valori dinamici un ancora 
// del tipo {{nome_variabile_da_sostituire}}. Quindi il processo da svolgere in ogni pagina php sarà :
// 1) Interrogare il database con la query per quella pagina, 
// 2)Caricare la pagina html del file dove lavorare -> 
// 3)caricare la sezione e rimpiazzare le variabili dinamiche con i valori ottenuti dal db -> Templating::getContentBetweenPlaceholders + Templating::replaceAnchor
// 4)fare il replacing della vecchiasezione con il nuovo codice html generato -> Templating::replaceContentBetweenPlaceholders
// 5) mostrare la pagina (rimuovere le ancore) -> Templating::showHtmlPageWithoutPlaceholders
// Tutte le funzioni saranno public static
session_start();


class Templating
{

    public const HTML_PATH = __DIR__
        . DIRECTORY_SEPARATOR . ".."
        . DIRECTORY_SEPARATOR . "html"
        . DIRECTORY_SEPARATOR;

    public static function errCode($num): void
    {
        http_response_code($num);
        require("{$num}.php");
    }
    /* Funzione per trovare {{ancora}} e sostituirla con valore dinamico */
    public static function replaceAnchor(&$htmlSectionToModify, $anchorNameBetweenBrackets, $dynamicDataToInsert): void
    {
        /* $anchorWithBrackets = "{{" . $anchorNameBetweenBrackets . "}}";
        $offsetOfAnchor = strpos($htmlSectionToModify,$anchorWithBrackets);
        if($offsetOfAnchor != false){
            $lengthOfAnchor = strlen($anchorWithBrackets);
            $htmlSectionToModify = substr_replace($htmlSectionToModify,$dynamicDataToInsert,$offsetOfAnchor,$lengthOfAnchor);
        } */
        $htmlSectionToModify = str_replace("{{" . $anchorNameBetweenBrackets . "}}", $dynamicDataToInsert, $htmlSectionToModify);

        //no need to return since the variable is passed by reference
    }


    /* Funzione per ottenere il contenuto html della sezione tra <!-- nome_sezione_start --> e <!--nome_sezione_end -->*/
    public static function getContentBetweenPlaceholders($htmlSectionToModify, $placeholderName): string
    {
        $startPlaceHolder = "<!-- " . $placeholderName . "_start -->";
        $endPlaceHolder = "<!-- " . $placeholderName . "_end -->";

        $regexPattern = "/\Q$startPlaceHolder\E(.*?)\Q$endPlaceHolder\E/s";
        preg_match($regexPattern, $htmlSectionToModify, $htmlSectionCaptured);
        //$htmlSectionCaptured[0] contiene il placeholder + content in $htmlSectionCaptured[1] ce solo il content
        return isset($htmlSectionCaptured[1]) ? $htmlSectionCaptured[1] : "";
    }

    /* Funzione per rimpiazzare il contenuto tra <!-- nome_sezione_start --> e <!--nome_sezione_end --> */
    public static function replaceContentBetweenPlaceholders(&$htmlSectionToReplace, $placeholderName, $contentToInsert): void
    {
        $startPlaceHolder = "<!-- " . $placeholderName . "_start -->";
        $endPlaceHolder = "<!-- " . $placeholderName . "_end -->";

        $regexPattern = "/\Q$startPlaceHolder\E(.*?)\Q$endPlaceHolder\E/s";

        $htmlSectionToReplace = preg_replace($regexPattern, $startPlaceHolder . $contentToInsert . $endPlaceHolder, $htmlSectionToReplace);
    }

    /* Funzione per tornare il contenuto della pagin html dato il nome del file*/
    public static function getHtmlFileContent($phpFileNameThatCalled): bool|string
    {

        $htmlFileFullPATH = Templating::HTML_PATH
            . str_replace(".php", ".html", basename($phpFileNameThatCalled));
        
        return file_get_contents($htmlFileFullPATH);
    }

    /* Funzione per togliere i placeholders (commenti html) prima di mostrare la pagina a schermo */
    public static function showHtmlPageWithoutPlaceholders(&$htmlPageToDisplay): void
    {

        $regexPattern = ["/<!-- (\w)+_start -->/", "/<!-- (\w)+_end -->/"];

        $htmlPageToDisplay = preg_replace($regexPattern, ["", ""], $htmlPageToDisplay);

        echo ($htmlPageToDisplay);

    }

    /* Funzione per convertire la data in formato YYYY-MM-DD in stringa italiana
     * nel formato 'dd Mese Anno' con il mese in italiano
     */
    public static function convertDateTimeToString($dataToConvert): string
    {

        // Crea un oggetto DateTime dalla stringa data nel formato 'yyyy-mm-dd'
        $dateIstance = DateTime::createFromFormat('Y-m-d', $dataToConvert);
        $formatter = new IntlDateFormatter(
            'it_IT', // Locale (italiano)
            IntlDateFormatter::LONG, // Formato per la data (LUNGO: 11 dicembre 2024)
            IntlDateFormatter::NONE  // Nessun formato per l'ora
        );
        // Verifica se la data è valida
        if ($dateIstance) {
            // Ritorna la data nel formato 'dd Mese Anno' con il mese in italiano
            return $formatter->format($dateIstance);
        } else {
            return "Data non valida";
        }
    }

    public static function generateSvgFromScore($scoreParam): string
    {
        $maxPossibleScore = 5;

        $htmlGenerated = '<svg id="rev-1" viewBox="0 0 128 24" width="88" height="16" aria-labelledby="lbl-rev-1">
        <title>Punteggio ' . $scoreParam . ' su ' . $maxPossibleScore . '</title>';
        for ($dotIteration = 0; $dotIteration < $maxPossibleScore; $dotIteration++) {
            $transform = "translate(" . ($dotIteration * 26) . " 0)";

            if ($dotIteration < $scoreParam) {
                $path = '<path d="M 12 0C5.388 0 0 5.388 0 12s5.388 12 12 12 12-5.38 12-12c0-6.612-5.38-12-12-12z" transform="' . $transform . '"></path>';
            } else {
                $path = '<path d="M 12 0C5.388 0 0 5.388 0 12s5.388 12 12 12 12-5.38 12-12c0-6.612-5.38-12-12-12zm0 2a9.983 9.983 0 019.995 10 10 10 0 01-10 10A10 10 0 012 12 10 10 0 0112 2z" transform="' . $transform . '"></path>';
            }

            $htmlGenerated .= $path;
        }
        return $htmlGenerated .= '</svg>';
    }

    public static function isAdmin(): bool
    {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    public static function getHtmlWithModifiedMenu($phpFileNameThatCalled): string
    {
        $htmlContent = Templating::getHtmlFileContent($phpFileNameThatCalled);
        if (!$htmlContent) {
            Templating::errCode(404);
            exit;
        }
        $log = Templating::getContentBetweenPlaceholders($htmlContent, 'log');
        $profile = Templating::getContentBetweenPlaceholders($htmlContent, 'profile');
        $admin = Templating::getContentBetweenPlaceholders($htmlContent, 'admin');
        $greeting = Templating::getContentBetweenPlaceholders($htmlContent, 'greeting');

        if (!isset($_SESSION['user_id'])) {
            $profile = '';
            $admin = '';
            $greeting = '';
        } elseif (!Templating::isAdmin()) {
            $log = '';
            $admin = '';
            Templating::replaceAnchor($greeting, 'username', $_SESSION['username']);
        } else {
            $log = '';
            Templating::replaceAnchor($greeting, 'username', $_SESSION['username']);
        }
        Templating::replaceContentBetweenPlaceholders($htmlContent, "log", $log);
        Templating::replaceContentBetweenPlaceholders($htmlContent, "profile", $profile);
        Templating::replaceContentBetweenPlaceholders($htmlContent, "admin", $admin);
        Templating::replaceContentBetweenPlaceholders($htmlContent, "greeting", $greeting);
        return $htmlContent;
    }
}
