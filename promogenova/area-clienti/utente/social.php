<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
$msgSalv="";

// NUOVO 
if (isset($_POST['upd']) && $_POST['upd']=="s") {
    
    // controllo
    if ($_POST['newAccount']==""){
    $msgErr="Devi inserire un NOME (nickname, profilo, account ecc.) valido";
    }
    if ($_POST['newUrl']==""){
    $msgErr="Devi inserire un indirizzo (URL) che rimandi al tuo profilo/account sul social network";
    }
    else{
    $msgErr=$myobj->ctrlSito($_POST['newUrl']);
    }

    // SALVATAGGIO
    if ($msgErr==""){

    $sql = 
    "
    INSERT INTO vetrine_social 
    (id,idAttivita,social,account,url) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newSocial']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newAccount']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newUrl']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovoINS=mysqli_insert_id($conn);
      
    $_POST['upd']="n";
    $msgSalv="Il social network &egrave; stato aggiunto.";
    }
}

// ELIMINA NUMERO
if (isset($_POST['rimoz']) && $_POST['rimoz']=="s") {
   $sql="DELETE FROM vetrine_social WHERE id='".$_POST['id']."'"; 
   $query=mysqli_query($conn,$sql);
   
   $_POST['id']=0;
   $msgSalv="L'account &egrave; stato rimosso.";
}


// MODIFICA NUMERO
if (isset($_POST['id']) && $_POST['id']>0) {
    
    // controllo
    if ($_POST['newAccount']==""){
    $msgErr="Devi inserire un NOME (profilo,pagina, account ecc.) valido";
    }
    if ($_POST['newUrl']==""){
    $msgErr="Devi inserire un indirizzo (URL) che rimandi al tuo profilo/account sul social network";
    }
    else{
    $msgErr=$myobj->ctrlSito($_POST['newUrl']);
    }

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine_social SET 
	  social='".mysqli_real_escape_string($conn,stripslashes($_POST['newSocial']))."',
	  account='".mysqli_real_escape_string($conn,stripslashes($_POST['newAccount']))."',
	  url='".mysqli_real_escape_string($conn,stripslashes($_POST['newUrl']))."'
	  WHERE id='".$_POST['id']."'";
      $query=mysqli_query($conn,$sql);
      
      $_POST['id']=0;
      $msgSalv="Le modifiche sono state salvate.";
    }
}

// leggi db
    $totSocial=0;
    $account=array(
	"id" => array (""),
	"account" => array (""),
	"social" => array (""),
	"url" => array ("")
    );

    $sql="SELECT id,social,account,url FROM vetrine_social WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $account['id'][]=$q['id'];
    $account['social'][]=$q['social'];
    $account['account'][]=$q['account'];
    $account['url'][]=$q['url'];
    $totSocial++;
    }


// struttura html
$title="Admin ".$attivita." - Profili e contatti sui social network (facebook, twitter, google plus, ecc.)";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Profili e contatti sui social network (facebook, twitter, google plus, ecc.)</h4><br />
<?php
if ($totSocial>0) {
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {

    for ($i=1;$i<count($account['id']);$i++) {
        print "<h5>Social: ".$i." di ".$totSocial."</h5>";
        print "<form id='modifSocial_".$account['id'][$i]."' method='post' action='?' class='riquadro'>";

        $icona="";
        switch ($account['social'][$i]){ 
        	case "Facebook": $icona="facebook.png"; break;
        	case "Twitter": $icona="twitter.png"; break;
        	case "You Tube": $icona="youtube.png"; break;
        	case "Google Plus": $icona="googleplus.png"; break;
        	case "Pinterest": $icona="pinterest.png"; break;
        	case "Linkedin": $icona="linkedin.png"; break;
        	case "Foursquare": $icona="foursquare.png"; break;
        	case "Flickr": $icona="flickr.png"; break;
        	case "Instagram": $icona="instagram.png"; break;
        	case "Messenger": $icona="windows-messenger.png"; break;
        	case "Skype": $icona="skype.png"; break;
        }

        print "<p><label>Social network e Nome Profilo/Contatto/Account";
            if ($icona!="") { print " <img src='".$url."/ico/".$icona."' alt='".$icona."' />";	}
        print "</label><br />";
        
        print "<select name='newSocial' option='1'>";
        print "<option value='Facebook'"; if ( $account['social'][$i]=="Facebook") { print " selected";}  print ">Facebook (profilo)</option>";
        print "<option value='Twitter'"; if ( $account['social'][$i]=="Twitter") { print " selected";}  print ">Twitter</option>";
        print "<option value='You Tube'"; if ( $account['social'][$i]=="You Tube") { print " selected";}  print ">You Tube</option>";
        print "<option value='Google Plus'"; if ( $account['social'][$i]=="Google Plus") { print " selected";}  print ">Google Plus</option>";
        print "<option value='Pinterest'"; if ( $account['social'][$i]=="Pinterest") { print " selected";}  print ">Pinterest</option>";
        print "<option value='Linkedin'"; if ( $account['social'][$i]=="Linkedin") { print " selected";}  print ">Linkedin</option>";
        print "<option value='Foursquare'"; if ( $account['social'][$i]=="Foursquare") { print " selected";}  print ">Foursquare</option>";
        print "<option value='Flickr'"; if ( $account['social'][$i]=="Flickr") { print " selected";}  print ">Flickr</option>";
        print "<option value='Instagram'"; if ( $account['social'][$i]=="Instagram") { print " selected";}  print ">Instagram</option>";
        print "<option value='Messenger'"; if ( $account['social'][$i]=="Messenger") { print " selected";}  print ">Windows Messenger</option>";
        print "<option value='Skype'"; if ( $account['social'][$i]=="Skype") { print " selected";}  print ">Skype</option>";
        print "</select> &nbsp;&nbsp;";
                
        print "<input type='text' size='20' name='newAccount' value='".$account['account'][$i]."' required /></p>";
        print "<p><label>Url</label><br />";
        print "<textarea name='newUrl' rows='2' cols='30' required>".$account['url'][$i]."</textarea></p>";
        
        print "<p><label>Rimuovere questo profilo?</label><br />";
        print "<select name='rimoz' option='1'>";
        print "<option value='n' selected>No, confermalo</option>";
        print "<option value='s'>S&igrave;, rimuovilo dal database</option>";
        print "</select></p>";

        print "<input type='hidden' name='id' value='".$account['id'][$i]."'/>";
        print "<p><input type='submit' name='salva' value='SALVA' class='bottSubmit' /></p>";
        print "</form><br /><br /><br />";
	}
}
else{
print "<h2 class='verde'>".$msgSalv."</h2>";
print "<a href='../'>Torna al Men&ugrave; principale</a> oppure <a href='?'>Visualizza e modifica di nuovo.</a><br /><br />";	
}
}
?>
<h5 class="verde">Aggiungi un account</h5>
<form id="nuovoSocial" method="post" action="?">

  <p><label>Seleziona un Social network<label><br />
  <select name="newSocial" option="1">
  <option value="Facebook" selected>Facebook (profilo)</option>
  <option value="Twitter">Twitter</option>
  <option value="You Tube">You Tube</option>
  <option value="Google Plus">Google Plus</option>
  <option value="Pinterest">Pinterest</option>
  <option value="Linkedin">Linkedin</option>
  <option value="Foursquare">Foursquare</option>
  <option value="Flickr">Flickr</option>
  <option value="Instagram">Instagram</option>
  <option value="Messenger">Windows Messenger</option>
  <option value="Skype">Skype</option>
  </select></p>
  
  <p><label>Nome (Profilo, Contatto o Nome ecc.)<label><br />
  <input type="text" size="30" name="newAccount" value="" required /></p>
  
  <p><label for="url">Url (indirizzo internet come da <a href="#esempio">esempio</a>)<label><br />  
  <textarea name="newUrl" id="url" rows="3" cols="30" required></textarea><br /><br /></p> 

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettato, il <b>Profilo/Contatto</b> deve rimandare direttamente al tuo <b>profilo personale</b> sul <i>Social network</i> (per pagine e gruppi passa a <a href="siti.php">Siti internet</a>). Attenzione: l'indirizzo <b>Url</b> deve comprendere la parte iniziale (<span class="rosso">http://</span>) altrimenti non sar&agrave; considerato valido.</p>
<p>Campi obbligatori: tutti.
<br /><br />
<?php include "../inc/es-url.php"; ?></p>
</div>
</div>
<?php
include "../footer.php";
?>
