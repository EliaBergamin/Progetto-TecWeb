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


class Templating{


    
    /* Funzione per trovare {{ancora}} e sostituirla con valore dinamico */
    public static function replaceAnchor(&$htmlSectionToModify, $anchorNameBetweenBrackets, $dynamicDataToInsert): void {
        $anchorWithBrackets = "{{" . $anchorNameBetweenBrackets . "}}";
        $offsetOfAnchor = strpos($htmlSectionToModify,$anchorWithBrackets);
        if($offsetOfAnchor != false){
            $lengthOfAnchor = strlen($anchorWithBrackets);
            $htmlSectionToModify = substr_replace($htmlSectionToModify,$dynamicDataToInsert,$offsetOfAnchor,$lengthOfAnchor);
        }
        //no need to return since the variable is passed by reference
    }
    

    /* Funzione per ottenere il contenuto html della sezione tra <!-- nome_sezione_start --> e <!--nome_sezione_end -->*/
    public static function getContentBetweenPlaceholders($htmlSectionToModify, $placeholderName) : string {
        $startPlaceHolder = "<!-- " . $placeholderName . "_start -->" ;
        $endPlaceHolder = "<!-- " . $placeholderName . "_end -->" ;

        $regexPattern = "/\Q$startPlaceHolder\E(.*?)\Q$endPlaceHolder\E/s";
        preg_match($regexPattern, $htmlSectionToModify, $htmlSectionCaptured);
        //$htmlSectionCaptured[0] contiene il placeholder + content in $htmlSectionCaptured[1] ce solo il content
        return isset($htmlSectionCaptured[1]) ? $htmlSectionCaptured[1] : "";
    }

    /* Funzione per rimpiazzare il contenuto tra <!-- nome_sezione_start --> e <!--nome_sezione_end --> */
    public static function replaceContentBetweenPlaceholders(&$htmlSectionToReplace, $placeholderName, $contentToInsert) : void {
        $startPlaceHolder = "<!-- " . $placeholderName . "_start -->" ;
        $endPlaceHolder = "<!-- " . $placeholderName . "_end -->" ;

        $regexPattern = "/\Q$startPlaceHolder\E(.*?)\Q$endPlaceHolder\E/s";

        preg_replace($regexPattern, $startPlaceHolder . $contentToInsert . $endPlaceHolder , $htmlSectionToReplace);

    }

    /* Funzione per tornare il contenuto della pagin html dato il nome del file*/
    public static function getHtmlFileContent() : string {
        $phpFileNameThatCalled = basename(__FILE__);
        $htmlFileFullPATH = dirname(__FILE__) . "/html" . "/" . str_replace(".php",".html",$phpFileNameThatCalled);
        
        return file_exists($htmlFileFullPATH) ? file_get_contents($htmlFileFullPATH) : "File not found";
    }

    /* Funzione per togliere i placeholders (commenti html) prima di mostrare la pagina a schermo */
    public static function showHtmlPageWithoutPlaceholders(&$htmlPageToDisplay) : void {

        $regexPattern = "/<!--\s*.*?_start\s*-->|\s*<!--\s*.*?_end\s*-->/s";

        preg_replace($regexPattern, "",$htmlPageToDisplay);

        echo($htmlPageToDisplay);

    }

}

?>