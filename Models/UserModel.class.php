<?php


class UserModel {

    private $ses;
    private $dId = "iduzivatele";
    private $dRole = "role";
    
    /**
     *  Pri vytvoreni objektu zahaji session.
     */
    public function __construct(){
        include_once("MySessions.class.php");
        $this->ses = new MySession;
    }
    
    /**
     *  Otestuje, zda je uzivatel prihlasen.
     *  @return boolean
     */
    public function isPrihlasen(){
        return $this->ses->isSessionSet($this->dId);
        //return true;
    }
    
    /**
     *  Nastavi do session jmeno uzivatele a datum prihlaseni.
     *  @param string $userName Jmeno uzivatele.
     */
    public function prihlasit($uzivatel){
        $this->ses->addSession($this->dId,$uzivatel["iduzivatele"]); 
        $this->ses->addSession($this->dRole,$uzivatel["prava"]);
    }
    
    /**
     *  Odhlasi uzivatele.
     */
    public function odhlasit(){
        $this->ses->removeSession($this->dId);
        $this->ses->removeSession($this->dRole);
    }
    
    public function maPravo($idprava){      
      return in_array($idprava, $this->ses->readSession($this->dRole));    
    }
    public function getIduzivatele (){
      return $this->ses->readSession($this->dId); 
    }
    
    
}

?>