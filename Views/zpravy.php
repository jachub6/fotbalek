
<?php
    global $data;    
    
    //include("functions.inc.php");
    echo getHeader($data["title"]);
    menu($data["title"]); 
?>

<div class="wrapper">
    
      <div class='topbar'><form method=get id=form-filtr>Rok
            <select name=rok class='date-picker' style='width:120px' onchange="jQuery('#form-filtr').submit();">
            <?php 
            foreach($data["option_roky"] as $option){
               echo $option;
            }
            ?>
            </select>
        </form>
       
      </div>
      <div class='topbar'><a href="?page=pridat_zpravu"><img src='img/add.png' alt='Přidat'></a></div>
      <?php 
       if(isset($data["zpravy"]))
         foreach($data["zpravy"] as $zprava){               
          echo "<div class='zpravy ".$zprava["class_archiv"]."'>";
          echo "<div class='zpravy-udaje ".$zprava["class_archiv"]."'>".$zprava["odkaz_uprava"];
          echo "<span style='color:gray;' class='".$zprava["class_archiv"]."'>".$zprava["cas_a_jmeno"]."</span>";
          echo "</div>";
          echo "<div class='zpravy-hlavicka ".$zprava["class_archiv"]."'>";                                                                
          echo "<b>".$zprava["hlavicka"]."</b>";
          echo "</div>";
          echo "<div class='zpravy-telo ".$zprava["class_archiv"]."'>";
          echo $zprava["telo"];
          echo "</div>";
          echo "</div>";    
         }
      
       
      
      ?>
      
      
</div>

<div id="dialog-confirm" style="display:none">Skutečně chcete odstranit?</div>
<div id="dialog-confirm-arch" style="display:none">Skutečně chcete archivovat?</div>
<div id="dialog-confirm-obn" style="display:none">Skutečně chcete obnovit?</div>    



<script type="text/javascript">

    function odstranit(id, archiv)
    { 
     var dialog_id="";
     if(parseInt(archiv)==1){
        dialog_id="#dialog-confirm"; 
     }
     else
     {
        dialog_id="#dialog-confirm-arch"; 
     }
     
     jQuery( dialog_id ).dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Ano": function() {
          window.location.replace("index.php?page=zpravy&id="+id+"&archiv="+archiv+"&rok=<?php echo $data["rok"]; ?>");
         jQuery( this ).dialog( "close" );
        },
        "Ne": function() {
          jQuery( this ).dialog( "close" );
        }
      }
    }); 
     
       
    }
    
     function obnovit(id)
    { 
     
     jQuery("#dialog-confirm-obn").dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Ano": function() {
          window.location.replace("index.php?page=zpravy&id="+id+"&obnovit=1&rok=<?php echo $data["rok"]; ?>");
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
