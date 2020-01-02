<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
require_once(DIRECTORY_CONTROLLERS."/ZakladniController.class.php");

class UdalostiController extends ZakladniController implements IController {
    public function show(string $pageTitle){       
     global $_GET;
      global $_POST;
     global $data;
     global $uzivatel;  
     $data = array(); 
     
        $data["title"] = $pageTitle;
       
        if(isset($_POST["rok"])){
            $rok=$_POST["rok"];
        }
        else
        {
            $rok=date("Y");          
        }
          $data["umoznit_pridavani"] = false;
         if($uzivatel->maPravo(2)){
            $data["umoznit_pridavani"] = true;
         }
       
        $radek = $this->db->getMinMaxRokUdalosti();
           
        $min_rok=$radek[0];
        $max_rok=$radek[1];
        
      
      $data["option_roky"] = array();  
      for($i=$max_rok;$min_rok<=$i;$i--){
        $data["option_roky"][] = "<option value=$i ".($rok==$i?"selected":"").">".$i."</option>";
      }
      
      

      $rady = $this->db->getUdalosti($rok);
      foreach($rady as $rada)                                   
      {
        $odkaz_uprava = "";
        if($uzivatel->maPravo(2))
        {          
            if($rada["archiv"]==0){
              $odkaz_uprava .= "<a class='edit' href='javascript: archiv(".$rada["idudalosti"].", 1)'><img src='img/delete.png' alt='Archivovat'></a>";
              $odkaz_uprava .= "<a class='edit' href='?page=pridat_udalost&id=".$rada["idudalosti"]."'><img src='img/edit.png' alt='Upravit'></a>";
              $odkaz_uprava .= "<a class='edit' href='?page=udalosti_vysledky&id=".$rada["idudalosti"]."'><img src='img/cup.png' alt='Výsledky'></a>";
            }
            else
            {
               $odkaz_uprava .= "<a class='edit' href='javascript: odstranit(".$rada["idudalosti"].")'><img src='img/delete.png' alt='Odstranit'></a>";
               $odkaz_uprava .= "<a class='edit' href='javascript: archiv(".$rada["idudalosti"].", 0)'><img src='img/obnovit.png' alt='Obnovit'></a>";
            }
        }
        else{
            if((!empty($rada[3])) and (!empty($rada[4]))){
                $odkaz_uprava .= "<a class='edit' href='?page=udalosti_vysledky&id=".$rada["idudalosti"]."'><img src='img/cup.png' alt='Výsledky'></a>";
            }
        }
           
        $data["udalosti"][] = array(
        "popis" => $rada["popis"],  
        "odkaz_uprava" => $odkaz_uprava, 
        "datum" => $rada["datum"], 
        "class_archiv" => ($rada["archiv"]==1?"archiv":""));
      }
      
     
          
        
        ob_start();
        require(DIRECTORY_VIEWS ."/udalosti.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}

?>