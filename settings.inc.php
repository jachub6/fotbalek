<?php


//nelze cist session z javascriptu
ini_set("session.cookie_httponly", 1);
/** Adresa databaze. */
define("DB_SERVER","localhost");
/** Nazev databaze. */
define("DB_NAME","soc");
/** Uzivatel databaze. */
define("DB_USER","root");
/** Heslo uzivatele databaze */
define("DB_PASS","");



//// Nazvy tabulek v DB ////
/** Tabulka s pohadkami. */
define("TABLE_INTRODUCTION", "orionlogin_mvc_introduction");
/** Tabulka s uzivateli. */
define("TABLE_USER", "orionlogin_mvc_user");

//// Dostupne stranky webu ////
/** Adresar kontroleru. */
define("DIRECTORY_CONTROLLERS", "Controllers");
/** Adresar modelu. */
define("DIRECTORY_MODELS", "Models");
/** Adresar sablon */
define("DIRECTORY_VIEWS", "Views");

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    // uvodni stranka
    "zpravy" => array("file_name" => "ZpravyController.class.php",
                    "class_name" => "ZpravyController",
                    "title" => "Zprávy"),
    // sprava uzivatelu
    "login" => array("file_name" => "LoginController.class.php",
                    "class_name" => "LoginController",
                    "title" => "Login"),
    "udalosti" => array("file_name" => "UdalostiController.class.php",
                    "class_name" => "UdalostiController",
                    "title" => "Události"),
    "statistiky" => array("file_name" => "StatistikyController.class.php",
                    "class_name" => "StatistikyController",
                    "title" => "Statistiky"),
                    
    "pridat_zpravu" => array("file_name" => "PridatZpravuController.class.php",
                    "class_name" => "PridatZpravuController",
                    "title" => "Přidat zprávu"),
      "pridat_udalost" => array("file_name" => "PridatUdalostController.class.php",
                    "class_name" => "PridatUdalostController",
                    "title" => "Přidat událost"),
);

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "zpravy";
const LOGIN_WEB_PAGE_KEY = "login";

?>