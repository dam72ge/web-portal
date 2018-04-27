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
    if ($_POST['newEmail']==""){
    $msgErr="Devi inserire un indirizzo di posta elettronica (email) valido";
    }
    else{
    $msgErr=$myobj->ctrlEmail($_POST['newEmail']);
    }


    // SALVATAGGIO
    if ($msgErr==""){

    $sql = 
    "
    INSERT INTO vetrine_email 
    (id,idAttivita,email,nota) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newEmail']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newNota']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovoINS=mysqli_insert_id($conn);
      
    $_POST['upd']="n";
    $msgSalv="La email &egrave; stata aggiunta.";
    }
}

// ELIMINA 
if (isset($_POST['rimoz']) && $_POST['rimoz']=="s") {
   $sql="DELETE FROM vetrine_email WHERE id='".$_POST['id']."'"; 
   $query=mysqli_query($conn,$sql);
   
   $_POST['id']=0;
   $msgSalv="La email &egrave; stata rimossa.";
}


// MODIFICA NUMERO
if (isset($_POST['id']) && $_POST['id']>0) {
    
    // controllo
    if ($_POST['newEmail']==""){
    $msgErr="Devi inserire un indirizzo di posta elettronica (email) valido.";
    }
    else{
    $msgErr=$myobj->ctrlEmail($_POST['newEmail']);
    }

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine_email SET 
	  email='".mysqli_real_escape_string($conn,stripslashes($_POST['newEmail']))."',
	  nota='".mysqli_real_escape_string($conn,stripslashes($_POST['newNota']))."'
	  WHERE id='".$_POST['id']."'";
      $query=mysqli_query($conn,$sql);
      
      $_POST['id']=0;
      $msgSalv="Le modifiche sono state salvate.";
    }
}

// leggi db
    $totEmail=0;
    $email=array(
	"id" => array (""),
	"email" => array (""),
	"nota" => array ("")
    );

    $sql="SELECT id,email,nota FROM vetrine_email WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $email['id'][]=$q['id'];
    $email['email'][]=$q['email'];
    $email['nota'][]=$q['nota'];
    $totEmail++;
    }


// struttura html
$title="Admin ".$attivita." - Contatti posta elettronica (e-mail)";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Contatti posta elettronica (e-mail)</h4><br />
<?php
if ($totEmail>0) {
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {

    for ($i=1;$i<count($email['id']);$i++) {
        print "<h5>Email: ".$i." di ".$totEmail."</h5>";
        print "<form id='modifEmail_".$email['id'][$i]."' method='post' action='?' class='riquadro'>";
        print "<p><label>Indirizzo di posta elettronica (E-mail)</label><br />";                
        print "<input type='text' size='20' name='newEmail' value='".$email['email'][$i]."' /></p>";
        print "<p><label>Nota</label><br />";
        print "<textarea name='newNota' rows='1' cols='30'>".$email['nota'][$i]."</textarea></p>";
        print "<p><label>Rimuovere questo email?</label><br />";
        print "<select name='rimoz' option='1'>";
        print "<option value='n' selected>No, confermalo</option>";
        print "<option value='s'>S&igrave;, rimuovilo dal database</option>";
        print "</select><br /><br /></p>";

        print "<input type='hidden' name='id' value='".$email['id'][$i]."'/>";
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
<h5 class="verde">Aggiungi un email</h5>
<form id="nuovoTelef" method="post" action="?">
  
  <p><label for="email">Indirizzo di posta elettronica (E-mail)<label><br />
  <input type="text" size="30" id="email" name="newEmail" value="" required /><br /><br /></p>
  
  <p><label>Nota all'E-mail<label><br />  
  <textarea name="newNota" rows="3" cols="30"></textarea><br /><br /></p> 

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettato, la <b>E-mail</b> deve essere un indirizzo di posta elettronica valido, con tanto di chiocciola. La <b>Nota</b> pu&ograve; essere usata per aggiungere informazioni utili quali p.es. la persona che risponde alle mail ecc.; se pubblicata, la Nota sar&agrave; visibile a tutti accanto all'indirizzo e-mail.</p>
<p>Campi obbligatori: Email.</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
