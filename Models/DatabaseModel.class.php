<?php
class DatabaseModel {

    private $pdo;

    public function __construct() {
        // inicializace DB
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        // vynuceni kodovani UTF-8
        $this->pdo->exec("set names utf8mb4");
    }

    public function getMinMaxRokZpravy(){
        $q = "select year(min(cas)), year(max(cas)) from zpravy";
        return $this->pdo->query($q)->fetch();
    }
    
    public function getMinMaxRokUdalosti(){
        $q = "select year(min(datum)), year(max(datum)) from udalosti";
        return $this->pdo->query($q)->fetch();
    }
    
    public function getUzivatelPodleEmailu(string $email){
      $stmt = $this->pdo->prepare("SELECT iduzivatele, email, heslo FROM uzivatele WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      return $stmt->fetch();
    }
    
    public function getPravaUzivatele($iduzivatele){
          $prava=array();
          $stmt = $this->pdo->prepare("select idprava from uzivatele_prava where iduzivatele= :iduzivatele");
          $stmt->bindParam(':iduzivatele', $iduzivatele);
          $stmt->execute();
          $dotaz = $stmt->fetchAll();
          
          foreach($dotaz as $d)
          {
            array_push($prava, $d["idprava"]);
          }
          return $prava;
    }
    
    
    public function getZpravy($rok){
      $stmt=$this->pdo->prepare("select t1.idzpravy, t1.hlavicka, t1.telo, t1.iduzivatele, t1.cas, t2.jmeno, t2.prijmeni, t1.archiv 
      from zpravy t1 
      left outer join uzivatele t2 on t2.iduzivatele=t1.iduzivatele 
      where YEAR(t1.cas)= :rok  
      order by t1.cas desc");
      
      $stmt->bindParam(':rok', $rok);
      $stmt->execute();
      return $stmt->fetchAll();
    }
    
    public function getUdalosti($rok){
      $stmt=$this->pdo->prepare("select idudalosti, popis, datum, vysledek1, vysledek2, archiv 
      from udalosti 
      where YEAR(datum)= :rok  
      order by datum desc");
      
      $stmt->bindParam(':rok', $rok);
      $stmt->execute();
      return $stmt->fetchAll();
    }
    
     public function odstranitZpravu($id, $archiv, $uzivatel){
          if($archiv==1)
          {     
                $sql="delete from zpravy where idzpravy='".$id."' ".($uzivatel->maPravo(2)?"":" and iduzivatel=".$uzivatel->getIduzivatele())." ";
                
          
          }else{
               $sql="update zpravy set archiv=1 where idzpravy='".$id."' ".($uzivatel->maPravo(2)?"":" and iduzivatel=".$uzivatel->getIduzivatele())." ";
                
          }
      return $this->pdo->query($sql);
    }
    public function obnovitZpravu($id, $uzivatel){
         
      $sql="update zpravy set archiv=0 where idzpravy='".$id."' ".($uzivatel->maPravo(2)?"":" and iduzivatel=".$uzivatel->getIduzivatele())." ";
                
        
      return $this->pdo->query($sql);
    }
    
    public function getZprava($id, $iduzivatele){
        if($iduzivatele == 0){
           $sql="select t1.hlavicka, t1.telo, t1.cas from zpravy t1 where idzpravy='".$id."'";
        }
        else
        {
           $sql="select t1.hlavicka, t1.telo, t1.cas from zpravy t1 where idzpravy='".$id."' and iduzivatele='".$iduzivatele."'";
        }
         return $this->pdo->query($sql)->fetch();
    }
    public function upravitZpravu($id, $hlavicka, $telo, $datum_cas, $uzivatel){
      $sql="UPDATE zpravy set 
      hlavicka='".$hlavicka."', 
      telo='".$telo."', 
      cas='".date("Y-m-d H:i:s", strtotime($datum_cas))."' 
      where idzpravy='".$id."' ".($uzivatel->maPravo(2)?"":" and iduzivatel=".$uzivatel->getIduzivatele()).";";
      return $this->pdo->query($sql);
    } 
    public function pridatZpravu($hlavicka, $telo, $datum_cas, $iduzivatele){
    $sql="INSERT INTO zpravy (hlavicka, telo, cas, iduzivatele)
                              VALUES ('".$hlavicka."','".$telo."', '".date("Y-m-d H:i:s", strtotime($datum_cas))."', '".$iduzivatele."');";
             return $this->pdo->query($sql);
    }  
    
    public function getPocetUdalostiVRoce($rok){
         $sql="select count(t2.idudalosti) from udalosti t2 where YEAR(t2.datum) = ".$rok." and t2.archiv=0 and t2.vysledek1 is not null";
         $pocet = $this->pdo->query($sql)->fetch();
         return $pocet[0];
    }   
    
    public function getStatistikyUspesnost($rok, $alespon_na_x_udalostech){
          $sql="select (sum(t1.body)/count(t1.iduzivatele)) as body, 
             t3.jmeno, 
             t3.prijmeni, 
             t1.iduzivatele, 
             if(count(t1.iduzivatele)>='$alespon_na_x_udalostech', 1, 0) as poradi,
             count(t1.iduzivatele) as pocet 
            from udalosti_uzivatele t1
            inner join udalosti t2 on t1.idudalosti=t2.idudalosti and t2.archiv=0 and t1.typ=2 and t2.vysledek1 is not null
            inner join uzivatele t3 on t3.iduzivatele=t1.iduzivatele
            where YEAR(t2.datum) = ".$rok."  
            group by t3.iduzivatele
            order by poradi desc, body desc, t3.prijmeni, t3.jmeno desc";
          return $this->pdo->query($sql)->fetchAll();   
    }                      


    
}

?>