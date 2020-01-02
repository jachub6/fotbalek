<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
    
    function getHeader($title)
    {
         return '<!DOCTYPE html>
              <html lang=cs>
              <head>
                  <meta charset="utf-8">
                  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                  <meta http-equiv="X-UA-Compatible" content="IE=edge">
                  <title>'.$title.'</title>
                  <meta name="description" content="">
                  <meta name="viewport" content="width=device-width, initial-scale=1">
                  <link rel="stylesheet" href="css/main4.css?v=4">
                  <link rel="stylesheet" href="css/photoswipe.css"> 
                  
                  <link rel="stylesheet" href="css/default-skin/default-skin.css"> 
                  
                  <script src="js/photoswipe.min.js"></script> 
                  
                  <script src="js/photoswipe-ui-default.min.js"></script> 
                  <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,500" rel="stylesheet" type="text/css">
                  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
                  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
                  <script src="textboxio-client/textboxio/textboxio.js"></script>
                  <script src="Chart.js/Chart.js"></script>
                  <script src="js/main.js?v=5" type="text/javascript"></script>
                  <script src="js/menu.js" type="text/javascript"></script>
                  <script src="https://www.google.com/recaptcha/api.js"></script>
              </head>
              <body>'; 
    }
    function getFooter(){
       return "</body></html>"; 
    }
    
    function loginForm($error, $hodnoty_get=array())
    { 
        if(!empty($_GET)){
           $text_vit="Nejprve se přihlašte";
        }
        else
        {
           $text_vit="Vítejte";
        }
    echo "<div class=uprostred>";
      echo "<form id='login-form' class='formular' name='form1' method='post' action='?'>
	    	    <input type='hidden' name='is_login' value='1'>
  	        <div class='h1'>$text_vit</div>
  	        <div id='form-content'>
  	            <div class='group'>
  	                <label for='email'>Email</label>
  	                <div><input id='email' name='email' class='form-control required' required type='email' placeholder='Email'></div>
  	            </div>
  	           <div class='group'>
  	                <label for='heslo'>Heslo</label>
  	                <div><input id='heslo' name='heslo' class='form-control required' required type='password' placeholder='Heslo'></div>
  	            </div>";
	      if($error) { 
	          echo '<em><label class="err" for="heslo" generated="true" style="display: block;">'.$error.'</label></em>';
				} 
	     echo '<div class="group submit">
	              <label class="empty"></label>
	                <div><input name="submit" type="submit" value="Přihlásit"/></div>
	           </div>
	        </div>';
      foreach($hodnoty_get as $name => $value){
        echo "<input type=hidden name='$name' value='$value'>";
      }
      foreach($_POST as $name => $value){
        if($name!="email" and $name!="heslo"){
          echo "<input type=hidden name='$name' value='$value'>";
        }       
      }
	   
       echo '</form>';
       echo "<br><a href='obnovit_heslo.php' style='display:block;text-align:center;'>Obnovit heslo</a>";
       echo '</div>';
      
    }
    
    function menu($zalozka="zpravy")
    {
        global $uzivatel;
      echo '<div class="topnav" id="myTopnav">';
      echo '<a href="?page=zpravy" class="'.($zalozka=="Zprávy"?"active":"").'">Zprávy</a>';
      echo '<a href="?page=udalosti" class="'.($zalozka=="Události"?"active":"").'">Události</a>';
      echo '<a href="?page=statistiky" class="'.($zalozka=="Statistiky"?"active":"").'">Statistiky</a>';
      echo '<a href="?page=galerie" class="'.($zalozka=="Galerie"?"active":"").'">Galerie</a>';
      if($uzivatel->maPravo(2)) {
       echo '<a href="?page=uzivatele" class="'.($zalozka=="Uživatelé"?"active":"").'">Uživatelé</a>';
      }
      echo '<a href="?page=ucet" class="'.($zalozka=="Můj účet"?"active":"").'">Můj účet</a>'; 
      echo '<a href="?logout=1" class="logout">Odhlásit se <li class="fa fa-sign-out"></li></a>';
      echo '<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>';
      echo '</div>';
    }
    
    function hlaska($pozitivni, $text_pozitivni, $text_negativni)
    {
      if($pozitivni){
        $class_hlaska="hlaska_true";
        $text="✔ ".$text_pozitivni;
      }
      else{
        $class_hlaska="hlaska_false";
        $text="✖ ".$text_negativni;
      }
      echo "<div class='$class_hlaska'>";
      echo $text;
      echo '</div>';
    }
    
      
      function odesli_email_gmail($komu,$subject,$body=""){
              /*   $od = "www-data@lojzacup.tomasnovy.cz";
     
                  $obsah = "<body><div style=\"font-family: Arial, Helvetica, sans-serif; font-size: 12px;\">\n 
                  $body
                  </div><br /><br /></body>";
                 
                  $headers = "";
                  $headers .= "Content-type: text/html;charset=utf-8\r\n";
                  $headers .= "Reply-To: The Sender <sender@domain.com>\r\n"; 
                  $headers .= "Return-Path: lojzacup <$od>\r\n"; 
                  $headers .= "From: lojzacup <$od>\r\n";  
                  $headers .= "Organization: lojzacup\r\n";
                  $headers .= "MIME-Version: 1.0\r\n";
                  $headers .= "X-Priority: 3\r\n";     

                  $posl=mail(trim($komu),$subject,$obsah,$headers); //odchozi email
                  return $posl;        */
                
          /*      $fromMail = 'www-data@lojzacup.tomasnovy.cz';
                $boundary = str_replace(" ", "", date('l jS \of F Y h i s A'));
                $subjectMail = $subject;
                
                
                $contentHtml = $obsah; 
                
                $headersMail = '';
                $headersMail .= 'From: ' . $fromMail . "\r\n" . 'Reply-To: ' . $fromMail . "\r\n";
                $headersMail .= 'Return-Path: ' . $fromMail . "\r\n";
                $headersMail .= 'MIME-Version: 1.0' . "\r\n";
                $headersMail .= "Content-Type: multipart/alternative; boundary = \"" . $boundary . "\"\r\n\r\n";
                $headersMail .= '--' . $boundary . "\r\n";
                $headersMail .= 'Content-Type: text/html; charset=utf-8' . "\r\n";
                $headersMail .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
                $headersMail .= rtrim(chunk_split(base64_encode($contentHtml)));
                
                try {
                    if (mail($komu, $subjectMail, "", $headersMail)) {
                        $status = 'success';
                        $msg = 'Mail sent successfully.';
                    } else {
                        $status = 'failed';
                        $msg = 'Unable to send mail.';
                    }
                } catch(Exception $e) {
                    echo $e->getMessage();
                }        */
                
                 $mail = new PHPMailer;
          //Tell PHPMailer to use SMTP
          $mail->isSMTP();
          //Enable SMTP debugging
          // 0 = off (for production use)
          // 1 = client messages
          // 2 = client and server messages
          $mail->SMTPDebug = 0;
          //Set the hostname of the mail server
          $mail->Host = 'smtp.gmail.com';
          $mail->CharSet = 'UTF-8';
          // use
           //$mail->Host = gethostbyname('smtp.gmail.com');
          // if your network does not support SMTP over IPv6
          //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
         // $mail->Port = 587;
          $mail->Port = 465;
          //Set the encryption system to use - ssl (deprecated) or tls
          $mail->SMTPSecure = 'ssl';
          //Whether to use SMTP authentication
          $mail->SMTPAuth = true;
          $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
          $mail->Username = "lojzacup@gmail.com";
          //Mp+3cQg@v5KnGgxM
          
          $mail->Password = "Mp+3cQg@v5KnGgxM"; 
          $mail->setFrom('lojzacup@gmail.com');
          
          $mail->addAddress($komu);
           
           $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = 'Tento prohlížeč nepodporuje emaily s HTML.';

          //Read an HTML message body from an external file, convert referenced images to embedded,
          //convert HTML into a basic plain-text alternative body
          //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
          //Replace the plain text body with one created manually
          //Attach an image file
          //$mail->addAttachment('images/phpmailer_mini.png');
          //send the message, check for errors
          if (!$mail->send()) {
                
              echo "Mailer Error: " . $mail->ErrorInfo;
              return false;
          } else {
            //  echo "Message sent!";
            return true;
          }
      
      }
      
function email_udalost_html_body($datum, $cas, $nazev, $id){
      
       $html_body='<table style="width: 500px; background-color: #263238;" align="center" cellspacing="0" cellpadding="0">
	<tr>
		<td style=" height: 65px; background-color: #80CBC4; border-bottom: 1px solid #4d4b48;">
		
		</td>
	</tr>
	<tr>
		<td>
			<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-left: 5px; padding-right: 5px; padding-bottom: 10px;">

				<tr bgcolor="#263238">
					<td style="padding-top: 32px;" align=center>
					<span style="font-size: 24px; color: white; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" >
						Vážený uživateli,					</span><br>
					</td>
				</tr>

				<tr>
					<td style="padding-top: 12px; font-size: 17px; color: #c6d4df; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
						dne 	<span style="color:white;font-size: 20px;" >'.date("j.n.Y", strtotime($datum)).'</span> v <span style="color:white;font-size: 20px;" >'.date("H:i", strtotime($cas)).'</span> se koná událost:				</td>
				</tr>

			    <tr>
					<td style="padding-top: 12px; font-size: 17px; color: #c6d4df; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
						<span style="color:white;font-size: 20px;">'.$nazev.'</span>				</td>
				</tr>

                <tr>
					<td style="padding-top: 24px; font-size: 17px; color: #c6d4df; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
						Zúčastníte se?				</td>
				</tr>
			

				<tr>
					<td style="font-size: 12px; color: #6d7880; padding-top: 30px; padding-bottom: 30px;" align=center>
						  
                      <a href="https://lojzacup.cz/udalosti_detail.php?typ=2&id='.$id.'" style="padding:10px;background:#00695C;text-decoration:none;color:white;font-size: 17px">Ano</a>
                      <a href="https://lojzacup.cz/udalosti_detail.php?typ=3&id='.$id.'" style="margin-left:25px;padding:10px;background:#E91E63;text-decoration:none;color:white;font-size: 17px">&nbsp;Ne&nbsp;</a>
					</td>
				</tr>

			</table>
		</td>
	</tr>

	<tr style="background-color: #80CBC4;">
		<td style="padding: 12px 24px; height: 65px;" align=center>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td align=center>
                    <a style="color:#263238;font-size: 10px;text-align:center;" href="https://lojzacup.cz/">lojzacup.cz</a>
                    </td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
return $html_body;
      }

      function email_uzivatel_html_body($id, $heslo){
      
       $html_body='<table style="width: 500px; background-color: #263238;" align="center" cellspacing="0" cellpadding="0">
	<tr>
		<td style=" height: 65px; background-color: #80CBC4; border-bottom: 1px solid #4d4b48;">
		
		</td>
	</tr>
	<tr>
		<td>
			<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-left: 5px; padding-right: 5px; padding-bottom: 10px;">

				<tr bgcolor="#263238">
					<td style="padding-top: 32px;" align=center>
					<span style="font-size: 24px; color: white; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" >
						Vítejte!					</span><br>
					</td>
				</tr>

				<tr>
					<td style="padding-top: 12px; font-size: 17px; color: #CFD8DC; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
					   Byl vám vytvořen účet na <a href="https://lojzacup.cz/zmenit_heslo.php?id='.$id.'" style="color:white;">lojzacup.cz</a>	
				</tr>

			    <tr>
					<td style="padding-top: 12px; font-size: 15px; color: #CFD8DC; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
						K prvnímu přihlášení použijte svůj e-mail a heslo: 				</td>
				</tr>
                
                 <tr>
					<td style="padding-top: 30px; font-size: 17px; color: #CFD8DC; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
						<span style="color:#80CBC4;font-size: 30px;">'.$heslo.'</span>				</td>
				</tr>

                <tr>
					<td style="padding-top: 30px; font-size: 10px; color: #CFD8DC; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
						Změnit si heslo můžete vždy <a href="https://lojzacup.cz/zmenit_heslo.php?id='.$id.'" style="color:white;">zde</a>				</td>
				</tr>
			


			</table>
		</td>
	</tr>

	<tr style="background-color: #80CBC4;">
		<td style="padding: 12px 24px; height: 65px;" align=center>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td align=center>
                    <a style="color:#263238;font-size: 10px;text-align:center;" href="https://lojzacup.cz/">lojzacup.cz</a>
                    </td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
return $html_body;
      }
 
 function email_obnovit_html_body($kod){
      
       $html_body='<table style="width: 500px; background-color: #263238;" align="center" cellspacing="0" cellpadding="0">
	<tr>
		<td style=" height: 65px; background-color: #80CBC4; border-bottom: 1px solid #4d4b48;">
		
		</td>
	</tr>
	<tr>
		<td>
			<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-left: 5px; padding-right: 5px; padding-bottom: 10px;">

				<tr bgcolor="#263238">
					<td style="padding-top: 32px;" align=center>
					<span style="font-size: 24px; color: white; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" >
						Žádost o obnovení					</span><br>
					</td>
				</tr>

				<tr>
					<td style="padding-top: 12px; font-size: 17px; color: #CFD8DC; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
					   Kód pro obnovení:	
				</tr>

                
                 <tr>
					<td style="padding-top: 30px; font-size: 17px; color: #CFD8DC; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
						<span style="color:#80CBC4;font-size: 30px;">'.$kod.'</span>				</td>
				</tr>

                <tr>
					<td style="padding-top: 30px; font-size: 10px; color: #CFD8DC; font-family: Arial, Helvetica, sans-serif; font-weight: bold;" align=center>
						Pokud jste o obnovení hesla nezažádali, email ignorujte.				</td>
				</tr>
			


			</table>
		</td>
	</tr>

	<tr style="background-color: #80CBC4;">
		<td style="padding: 12px 24px; height: 65px;" align=center>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td align=center>
                    <a style="color:#263238;font-size: 10px;text-align:center;" href="https://lojzacup.cz/">lojzacup.cz</a>
                    </td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
return $html_body;
      }     
      
    
?>
