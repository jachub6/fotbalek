
<?php
    global $data;    
    
   
    echo getHeader($data["title"]);
?>

   <div class=uprostred>
      <form id='login-form' class='formular' name='form1' method='post'>
  	        <div class='h1'>Vítejte!</div>
  	        <div id='form-content'>
  	            <div class='group'>
  	                <label for='email'>Email</label>
  	                <div><input id='email' name='email' class='form-control required' required type='email' placeholder='Email'></div>
  	            </div>
  	           <div class='group'>
  	                <label for='heslo'>Heslo</label>
  	                <div><input id='heslo' name='heslo' class='form-control required' required type='password' placeholder='Heslo'></div>
  	            </div>
        <?php
         if(isset($data["error"])) { 
	          echo '<em><label class="err" for="heslo" generated="true" style="display: block;">'.$data["error"].'</label></em>';
				} 
        ?>
	    <div class="group submit">
	              <label class="empty"></label>
	                <div><input name="submit" type="submit" value="Přihlásit"/></div>
	           </div>
	        </div>

       </form>
       <br><a href='obnovit_heslo.php' style='display:block;text-align:center;'>Obnovit heslo</a>
       </div>

<?php
    echo getFooter(); 
