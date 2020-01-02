<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
require_once(DIRECTORY_CONTROLLERS."/ZakladniController.class.php");

class PridatZpravuController extends ZakladniController implements IController {
    public function show(string $pageTitle){       
     global $_GET;
     global $data;
     global $uzivatel; 
     
     
     if(isset($_POST["upravit_zpravu"])){
        if(isset($_POST["hlavicka"]) and isset($_POST["telo"]) and isset($_POST["upravit_id"]) and isset($_POST["datum"])){
           $dotaz = $this->db->upravitZpravu($_POST["upravit_id"], $_POST["hlavicka"], $_POST["telo"], $_POST["datum"], $uzivatel);                           
           if($dotaz){
              header("Location: index.php?page=zpravy");
           }
           else
           {
              hlaska(false, "", "Chyba: Nepodařilo se upravit");
           } 
        }
        else{
          hlaska(false, "", "Chyba: Nepodařilo se upravit");
        }
        
    }
    
    if(isset($_POST["pridat_zpravu"])){
        if(isset($_POST["hlavicka"]) and isset($_POST["telo"]) and isset($_POST["datum"])){
            
            
              
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
     
     
      
     $data = array(); 
     
        $data["title"] = $pageTitle;
       
        $data["telo"]="";
        $data["hlavicka"]="";
        $data["upravit"]= false;
        $data["datum"] = date("Y-m-d"); 
        if(isset($_GET['id']))
        { 
          if($uzivatel->maPravo(2))
          {
            $rada = $this->db->getZprava($_GET['id'], 0);
          }
          else
          {
            $rada = $this->db->getZprava($_GET['id'], $uzivatel->getIduzivatele());
          }
          
           if(!empty($rada)){
             $data["telo"]=$rada[1];
            $data["hlavicka"]=$rada[0];
            $data["datum"]=date("Y-m-d", strtotime($rada[2]));
            $data["upravit"] = true;
           } 
            
         
        }  
          
        
        ob_start();
        require(DIRECTORY_VIEWS ."/pridat_zpravu.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}

?>