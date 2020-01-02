<?php
    global $data;    
    
    echo getHeader($data["title"]);
    menu($data["title"]); 
?> 
     <div class="wrapper" >       
                 <?php  
                 if($data["muze_pridat"])
                 {  ?>
                         
                	        <div class="formular">
                            <form method="post" action="udalosti.php" onsubmit="return kontrola();">                        
                	            <div class="group">
                	                <label for="popis">Popis</label>
                	                <div><input id="popis" name="popis" class="form-control valid" type="text" maxlength="150" required value="<?php echo $data["popis"];?>"></div>
                                  <p id="popis_valid"></p>
                	            </div>
                	           <div class="group">
                	                <label for="datum">Datum</label>
                	                <div><input id="datum" name="datum" class="form-control valid" type="date" required value="<?php echo $data["datum"]; ?>"></div>
                                  <p id="datum_valid"></p>
                	            </div>
                               <div class="group">
                	                <label for="cas">Čas</label>
                                  <div><input name="cas" id="cas" type="time" class="form-control valid" required value="<?php echo $data["cas"]; ?>"></div>
                                  <p id="cas_valid"></p>
                              </div>
                               <br><input type=checkbox style='position:absolute;left:-9999px;' id=zobrazit_check value='1'><label style='display:block;width:100%;text-align:center;' for=zobrazit_check id=label_zobrazit>▼ Zobrazit uživatele ▼</label>
                              <div id="zobrazit_div" style="display:none;">
                	             
                                      <br><table class=zaplaceno cellspacing=4 cellpadding=4>
                                      <tr class=table-header><td align=center style='width:50px;'>
                                      <input type=checkbox id=vsechny onchange="check_all('vsechny', this);">
                                      </td><td>Všichni uživatelé</td></tr>
                                       <?php
                                     /* while($rada_uzivatele = vytahniradu($dotaz_uzivatele)){
                                          
                                          echo "<tr><td align=center>";
                                          echo "<input class=vsechny type=checkbox name=iduzivatele_udalost[] value='$rada_uzivatele[0]' ".(in_array($rada_uzivatele[0],$array_uzivatele)?"checked":"ne").">";
                                          echo "</td><td>$rada_uzivatele[1] $rada_uzivatele[2]</td></tr>";
                                      }   */
                                      ?>
                                      </table>              
                              </div>
                                  <?php
                                  if(!isset($data["id"]))
                                  {                                 
                                     echo '<div class="group submit"><label class="empty"></label><div><input name="pridat" type="submit"  value="Přidat"></div></div>';
                                  }
                                  else
                                  {  
                                      
                                     echo "<input type=hidden name=upravit_id value='".$data["id"]."'>";
                                     echo '<div><input name="upravit" type="submit"  value="Upravit"></div></div>';                      
                                  }
                                  ?>                               
                	        </form>    
                	        </div>

              <?php }
                    else
                    {
                     echo "<h1 style='text-align:center'>Nemáte potřebná práva k vytvoření události!</h1>";
                    }
              ?>
       	
				</div>
    <script type="text/javascript">

    
    function check_all(check_class, element)
    {
        if(jQuery(element).prop("checked")){
            jQuery("."+check_class).each(function(){
                jQuery(this).prop("checked", true);
            });
        }
        else{
           jQuery("."+check_class).each(function(){
                jQuery(this).prop("checked", false);
            });
        }
    }
    
    jQuery(document).ready(function(){
        
        if(jQuery(".vsechny:checked").length==jQuery(".vsechny").length){
           jQuery("#vsechny").prop("checked", true);
        }
        else{
           jQuery("#vsechny").prop("checked", false);
        }
        
        jQuery(".vsechny").change(function(){
           if(jQuery(".vsechny:checked").length==jQuery(".vsechny").length){
           jQuery("#vsechny").prop("checked", true);
        }
        else{
           jQuery("#vsechny").prop("checked", false);
        }
        });
        
        jQuery("#zobrazit_check").change(function(){
            if(jQuery("#zobrazit_check").prop("checked")){
              jQuery("#zobrazit_div").show();
              jQuery("#label_zobrazit").html("▲ Skrýt uživatele ▲");   
            }
            else{
              jQuery("#zobrazit_div").hide();
              jQuery("#label_zobrazit").html("▼ Zobrazit uživatele ▼"); 
            }
        });
        
    });

    function kontrola()
    {
      if(validuj())
      {
        return true;
      }
      else
      {
        return false;
      }
      
    }
        
    jQuery(document).ready(function () {
    jQuery(document).ajaxStart(function () {
        jQuery("#loading").show();
    }).ajaxStop(function () {
        jQuery("#loading").hide();
    });
    });
    </script>   
<?php
    echo getFooter(); 
?> 
