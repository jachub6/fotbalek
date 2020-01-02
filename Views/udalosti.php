<?php
    global $data;    
    
    
    echo getHeader($data["title"]);
    menu($data["title"]); 
?>

    <div class="wrapper">
     
      <div class='topbar'><form method=post id=form-filtr action='index.php?page=udalosti'>Rok
       <select name=rok class='date-picker' style='width:120px' onchange="jQuery('#form-filtr').submit();">
            <?php 
            foreach($data["option_roky"] as $option){
               echo $option;
            }
            ?>
        </select>
      </form></div>
      <?php
       
       if($data["umoznit_pridavani"]){
          echo "<div class='topbar'><a href='?page=pridat_udalost'><img src='img/add.png' alt='Přidat'></a></div>";
       }
       else{
         echo "<br>";
         echo "<br>";
       }
       
      if(isset($data["udalosti"]) and !empty($data["udalosti"])){
        foreach($data["udalosti"] as $udalost){
         echo "<div class='zpravy ".$udalost["class_archiv"]."'  style='cursor:pointer'>".$odkaz_uprava;
          
          if($udalost["class_archiv"]=="archiv"){
             echo "<div class='archiv'>";
          }
          else
          {
             echo "<div class='onhover' onclick='detail($rada[0])'>";
          }
          echo "<div class='zpravy-udaje ".$udalost["class_archiv"]."'>";
          echo "<span style='color:gray;' class='".$udalost["class_archiv"]."'>".date("j.n.Y H:i", strtotime($udalost["datum"]))."</span>";
          echo "</div>";
          echo "<div class='zpravy-hlavicka ".$udalost["class_archiv"]."'>";                                                                
          echo "<b>".$udalost["popis"]."</b>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
        }
      }
      else{
        echo "<h1 style='text-align:center;'>V tomto období neexistují žádné události</h1>";
      }
         
     ?>
    </div>
     <div id="dialog-confirm" style="display:none">
    Skutečně chcete odstranit?
    </div>
    <div id="dialog-confirm-arch" style="display:none">
    Skutečně chcete archivovat?
    </div>
    <div id="dialog-confirm-obn" style="display:none">
    Skutečně chcete obnovit?
    </div>
      
    <script type="text/javascript">
    function odstranit(id)
    {
    
    jQuery( "#dialog-confirm" ).dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Ano": function() {
            jQuery.ajax({
                  type:'POST', 
                  url:'ajax/ajax_udalost_odstranit.php', 
                  async: false, 
                  data: {'id':id},  
                  success:function(data){
                      if(data=="")
                      {
                        location.reload();
                      }
                      else
                      {
                        alert("Chyba");
                      }   
                      
                  }
            });
      jQuery( this ).dialog( "close" );
        },
        "Ne": function() {
          jQuery( this ).dialog( "close" );
        }
      }
    });
    }
    
    function detail(id){
      window.location.href='index.php?page=pridat_udalost&id='+id;
    }
    
         function archiv(id, archivovat)
    { 
     
     var str="#dialog-confirm-obn";
     if(archivovat==1){
        var str="#dialog-confirm-arch";
     }
     
     
     jQuery(str).dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Ano": function() {
          jQuery.ajax({
            type:'POST', 
            url:'ajax/ajax_udalosti_archiv.php', 
            async: false, 
            data: {
            'id':id,
            'archivovat':archivovat
            },  
            success:function(data){
                if(data=="")
                {
                  location.reload();
                }
                else
                {
                  alert("Chyba");
                }   
                
            }
      });
         jQuery( this ).dialog( "close" );
        },
        "Ne": function() {
          jQuery( this ).dialog( "close" );
        }
      }
    }); 
     
       
    }
    </script> 
<?php
    echo getFooter(); 
?> 

