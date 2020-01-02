<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
require_once(DIRECTORY_CONTROLLERS."/ZakladniController.class.php");

class PridatUdalostController extends ZakladniController implements IController {
    public function show(string $pageTitle){       
     global $_GET;
     global $_POST;
     global $data;
     global $uzivatel; 
     $data["title"]=$pageTitle;
     
      if(isset($_POST["pridat"])){
        if(isset($_POST["popis"]) and isset($_POST["datum"]) and isset($_POST["cas"])){
            
            
              
            $dotaz = $this->db->pridatZpravu($_POST["hlavicka"], $_POST["telo"], $_POST["datum"], $uzivatel->getIduzivatele()); 
            if($dotaz){
              header("Location: index.php");
           }
           else
           {
             hlaska(false, "", "Chyba: Nepodařilo se přidat");
           } 
        }else{
          hlaska(false, "", "Chyba: Nepodařilo se přidat");
        }
    } 
     
     
     
     $data["muze_pridat"] = true;
      $data["popis"] = "";
       $data["cas"] = date("H:i");
        $data["datum"] = date("Y-m-d");
        
        
     
        
        ob_start();
        require(DIRECTORY_VIEWS ."/pridat_udalost.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}

?>