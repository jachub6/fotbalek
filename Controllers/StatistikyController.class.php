<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
require_once(DIRECTORY_CONTROLLERS."/ZakladniController.class.php");

class StatistikyController extends ZakladniController implements IController {
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
        
       
        $radek = $this->db->getMinMaxRokUdalosti();
           
        $min_rok=$radek[0];
        $max_rok=$radek[1];
        
      
      $data["option_roky"] = array();  
      for($i=$max_rok;$min_rok<=$i;$i--){
        $data["option_roky"][] = "<option value=$i ".($rok==$i?"selected":"").">".$i."</option>";
      }

            $pocet_udalosti=$this->db->getPocetUdalostiVRoce($rok);
            $alespon_na_x_udalostech=$pocet_udalosti/2;

           
           
            
             $data["body"] = array();
            $i=0;
            $minuly_pod_pulku=1;
            $rady_body = $this->db->getStatistikyUspesnost($rok, $alespon_na_x_udalostech);
            $minule_body=0;
            foreach($rady_body as $rada){
              
              $body = (empty($rada[0])?"0":"$rada[0]");
              if($minule_body!=$body){
                  $i++;
              }
              
           
              
             /* if($rada[4]!=$minuly_pod_pulku){
               echo "<tr class='archiv'><td colspan=4 align=center style='border-bottom-style:solid;border-bottom-width:2px;'>Pod 50% úèasti</td></tr>";
              } */
                   
    
              
               $data["body"][] = array(
              "poradi" => $i.".", 
              "jmeno" => $rada[2]." ".$rada[1], 
              "body" => round($body, 2), 
              "pocet_ucasti" => $rada[5],
               "pod" => $rada[4],
              "class_bold" => ($rada[3]==$uzivatel->getIduzivatele()?"bold":""));
              
                          
              $minule_body=$body;
              $minuly_pod_pulku=$rada[4]; 
            }
      
      

    
        
        ob_start();
        require(DIRECTORY_VIEWS ."/statistiky.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}

?>