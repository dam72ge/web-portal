<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
$msgSalv="";

// NUOVO NUMERO
if (isset($_POST['upd']) && $_POST['upd']=="s") {
    
    // controllo
    if ($_POST['newParola']==""){
    $msgErr="Devi inserire una parola.";
    }

    // SALVATAGGIO
    if ($msgErr==""){

    $sql = 
    "
    INSERT INTO vetrine_tag 
    (id,idAttivita,parola) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newParola']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovoINS=mysqli_insert_id($conn);
      
    $_POST['upd']="n";
    $msgSalv="La parola &egrave; stata aggiunta.";
    }
}

// ELIMINA NUMERO
if (isset($_POST['rimoz']) && $_POST['rimoz']=="s") {
   $sql="DELETE FROM vetrine_tag WHERE id='".$_POST['id']."'"; 
   $query=mysqli_query($conn,$sql);
   
   $_POST['id']=0;
   $msgSalv="Il parola &egrave; stata rimossa.";
}


// MODIFICA NUMERO
if (isset($_POST['id']) && $_POST['id']>0) {
    
    // controllo
    if ($_POST['newParola']==""){
    $msgErr="Devi inserire il parola.";
    }

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine_tag SET 
	  parola='".mysqli_real_escape_string($conn,stripslashes($_POST['newParola']))."'
	  WHERE id='".$_POST['id']."'";
      $query=mysqli_query($conn,$sql);
      
      $_POST['id']=0;
      $msgSalv="Le modifiche sono state salvate.";
    }
}

// leggi db
    $totParole=0;
    $tag=array(
	"id" => array (""),
	"parola" => array ("")
    );

    $sql="SELECT id,parola FROM vetrine_tag WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $tag['id'][]=$q['id'];
    $tag['parola'][]=$q['parola'];
    $totParole++;
    }


// struttura html
$title="Admin ".$attivita." - Parole chiave";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Parole chiave</h4><br />
<?php
if ($totParole>0) {
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {

    for ($i=1;$i<count($tag['id']);$i++) {
        print "<h5>Parola: ".$i." di ".$totParole."</h5>";
        print "<form id='modifParole_".$tag['id'][$i]."' method='post' action='?' class='riquadro'>";
        
        print "<p><label>Parola</label><br /> ";    
        print "<input type='text' size='20' name='newParola' value='".$tag['parola'][$i]."' pattern='[a-zA-Z0-9]{3,25}' /></p>";

        print "<p><label>Rimuovere questa parola?</label><br />";
        print "<select name='rimoz' option='1'>";
        print "<option value='n' selected>No, confermala</option>";
        print "<option value='s'>S&igrave;, rimuovila dal database</option>";
        print "</select></p><br />";

        print "<input type='hidden' name='id' value='".$tag['id'][$i]."'/>";
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
<h5 class="verde">Aggiungi una parola</h5>
<form id="nuovaParola" method="post" action="?">

  <p><label>Parola<label><br />
  <input type="text" size="30" name="newParola" value="" pattern="[a-zA-Z0-9]{3,25}" required /><br /><br /></p>
  
  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Le <b>Parole chiave</b> sono concepite per agevolare il visitatore del portale nella ricerca della tua Attivit&agrave;. Per essere accettata, ogni singola <b>Parola chiave</b> deve essere formata <span class="rosso">da 3 a 25 caratteri alfanumerici</span> (lettere e/o numeri, senza spazi, punti, virgole o altre forme di separazione). </p>
<p>Campi obbligatori: nessuno. L'inserimento delle parole &egrave; facoltativo.</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
