<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
require_once(DIRECTORY_CONTROLLERS."/ZakladniController.class.php");

class LoginController extends ZakladniController implements IController {
    public function show(string $pageTitle){       
     global $_GET;
     global $data; 
     global $uzivatel; 
     $data = array(); 
     
        $data["title"] = $pageTitle;

         if(isset($_POST["submit"]) and isset($_POST["email"]) and isset($_POST["heslo"])){    		
            $user = $this->db->getUzivatelPodleEmailu($_POST["email"]);               
    		if(!empty($user)){
                if(password_verify($_POST['heslo'], $user['heslo'])){                  
                  $user['prava'] = $this->db->getPravaUzivatele($user['iduzivatele']);                
          		  $uzivatel->prihlasit($user);
                  header("Location: index.php",TRUE,301);         		
                }
                else{
                  $data["error"] = 'Špatný email nebo heslo.';
                  $user=""; 
                }         
    		}
    		else{
    			$data["error"] = 'Špatný email nebo heslo.';
    		}
         }
        
        
        ob_start();
        require(DIRECTORY_VIEWS ."/login.php");
        $obsah = ob_get_clean();
        return $obsah;
    }
}

?>