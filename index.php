<?php


ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// spustim aplikaci
 require_once("settings.inc.php");
 require_once(DIRECTORY_MODELS ."/UserModel.class.php");
 require_once("functions.inc.php");
global $uzivatel;
$uzivatel = new UserModel();
$app = new ApplicationStart();
$app->appStart();

/**
 * Vstupni bod webove aplikace.
 */
class ApplicationStart {
  
    /**
     * Inicializace webove aplikace.
     */
    public function __construct()
    {
        // nactu nastaveni
       
        // nactu rozhrani kontroleru
        require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
        
    }

    /**
     * Spusteni webove aplikace.
     */
    public function appStart(){
       global $uzivatel;
        
        if(isset($_GET["logout"])){
            $uzivatel->odhlasit();
        }
        
        if($uzivatel->isPrihlasen()){
            if(isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)){
                $pageKey = $_GET["page"]; // nastavim pozadovane
            } else {
                $pageKey = DEFAULT_WEB_PAGE_KEY; // defaulti klic
            }
            
        }
        else
        {
       
           $pageKey = LOGIN_WEB_PAGE_KEY;
        }
        
        
        $pageInfo = WEB_PAGES[$pageKey];
    
            //// nacteni odpovidajiciho kontroleru, jeho zavolani a vypsani vysledku
            // pripojim souboru ovladace
            require_once(DIRECTORY_CONTROLLERS ."/". $pageInfo["file_name"]);
    
            // nactu ovladac a bez ohledu na prislusnou tridu ho typuju na dane rozhrani
            /** @var IController $controller  Ovladac prislusne stranky. */
            $controller = new $pageInfo["class_name"];
    
            // zavolam prislusny ovladac a vypisu jeho obsah
            echo $controller->show($pageInfo["title"]);
       

    }
}

?>