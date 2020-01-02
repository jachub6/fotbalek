<?php
    global $data;    
    
    echo getHeader($data["title"]);
    menu($data["title"]); 
?>
    
    <div class="wrapper">
    
      <div class="formular">
      <form method="post">
        <div class="group">
              <label for="datum">Datum</label>
                <div><input id="datum" name="datum" class="form-control valid" type="date" required value="<?php echo $data["datum"]; ?>"></div>
              <p id="datum_valid"></p>
        </div>
      <div class="group"><label for=hlavicka>Titulek</label><div><input id=hlavicka class="form-control" type=text name="hlavicka" value="<?php echo $data["hlavicka"]; ?>" required></div></div>
      <div><textarea id=telo name="telo" style="height:300px;" class="form-control"><?php echo $data["telo"]; ?></textarea></div>
      <div class="group submit"><label class="empty"></label><div>
      
      <?php if($data["upravit"])
            {
               echo "<input name='upravit_id' type=hidden value='".$_GET['id']."'>";
               echo "<input name='upravit_zpravu' type=hidden value='1'>";     
               echo "<input type=submit value=Upravit>";
            }
            else
            {
               echo "<input name='pridat_zpravu' type=hidden value='1'>";  
               echo "<input type=submit value=Přidat>";
            }
            
      ?>
	     </div></div>
      </form>
      </div>
    </div>
    <script type="text/javascript">
    
    var config = {
    images : {
            editing : {
                preferredWidth : 500
            }
        }
    };    
    var editor = textboxio.replace('#telo', config);
    </script>    
<?php
    echo getFooter(); 
?> 
