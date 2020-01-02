<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
require_once(DIRECTORY_CONTROLLERS."/ZakladniController.class.php");

class ZpravyController extends ZakladniController implements IController {
    public function show(string $pageTitle){       
     global $_GET;
     global $data;
     global $uzivatel;  
     $data = array(); 
     
        if(isset($_GET["obnovit"]) and isset($_GET["id"])){
          $this->db->obnovitZpravu($_GET["id"], $uzivatel);  
        }
        
        if(isset($_GET["archiv"]) and isset($_GET["id"])){
          $this->db->odstranitZpravu($_GET["id"],$_GET["archiv"],  $uzivatel);  
        }
     
     
        $data["title"] = $pageTitle;
       
       
        
       
        $radek = $this->db->getMinMaxRokZpravy();
           
        $min_rok=$radek[0];
        $max_rok=$radek[1];
        
        if(isset($_GET["rok"])){
            $rok=$_GET["rok"];
        }
        else
        {
            $rok=$max_rok;          
        }
        
        if($max_rok < date("Y")){
            $max_rok = date("Y");
        }
        
      
      $data["option_roky"] = array();  
      for($i=$max_rok;$min_rok<=$i;$i--){
        $data["option_roky"][] = "<option value=$i ".($rok==$i?"selected":"").">".$i."</option>";
      }
      $data["rok"] =$rok;
      

      $rady = $this->db->getZpravy($rok);
      foreach($rady as $rada)                                   
      {
        $odkaz = "";
        if($uzivatel->getIduzivatele()==$rada["iduzivatele"] or $uzivatel->maPravo(2))
        {          
           if($rada["archiv"] == 1){
               $odkaz  .= "<a class='edit' href=\"javascript: odstranit('".$rada["idzpravy"]."', '1')\"><img src='img/delete.png' alt='Odstranit'></a>";
               $odkaz  .= "<a class='edit' href=\"javascript: obnovit('".$rada["idzpravy"]."')\"><img src='img/obnovit.png' alt='Obnovit'></a>";
           }
           else
           {
               $odkaz  .= "<a class='edit' href=\"javascript: odstranit('".$rada["idzpravy"]."', '0')\"><img src='img/delete.png' alt='Archivovat'></a>";
               $odkaz .= "<a class='edit' href='?page=pridat_zpravu&id=".$rada["idzpravy"]."'><img src='img/edit.png' alt='Upravit'></a>";
           }
        }
           
        $data["zpravy"][] = array(
        "telo" => $rada["telo"], 
        "hlavicka" => htmlSpecialChars($rada["hlavicka"]), 
        "odkaz_uprava" => $odkaz, 
        "cas_a_jmeno" => htmlSpecialChars(date("j.n.Y h:i", strtotime($rada["cas"]))." - ".$rada["jmeno"]." ".$rada["prijmeni"]), 
        "class_archiv" => ($rada["archiv"]==1?"archiv":""));
      }
      
     
          
        
        ob_start();
        require(DIRECTORY_VIEWS ."/zpravy.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}

?>