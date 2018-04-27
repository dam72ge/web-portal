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
    if ($_POST['newNumero']==""){
    $msgErr="Devi inserire il numero.";
    }

    // SALVATAGGIO
    if ($msgErr==""){

    $sql = 
    "
    INSERT INTO vetrine_telefoni 
    (id,idAttivita,tipo,numero,nota) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newTipo']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newNumero']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newNota']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovoINS=mysqli_insert_id($conn);
      
    $_POST['upd']="n";
    $msgSalv="Il numero &egrave; stato aggiunto.";
    }
}

// ELIMINA NUMERO
if (isset($_POST['rimoz']) && $_POST['rimoz']=="s") {
   $sql="DELETE FROM vetrine_telefoni WHERE id='".$_POST['id']."'"; 
   $query=mysqli_query($conn,$sql);
   
   $_POST['id']=0;
   $msgSalv="Il numero &egrave; stato rimosso.";
}


// MODIFICA NUMERO
if (isset($_POST['id']) && $_POST['id']>0) {
    
    // controllo
    if ($_POST['newNumero']==""){
    $msgErr="Devi inserire il numero.";
    }

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine_telefoni SET 
	  tipo='".mysqli_real_escape_string($conn,stripslashes($_POST['newTipo']))."',
	  numero='".mysqli_real_escape_string($conn,stripslashes($_POST['newNumero']))."',
	  nota='".mysqli_real_escape_string($conn,stripslashes($_POST['newNota']))."'
	  WHERE id='".$_POST['id']."'";
      $query=mysqli_query($conn,$sql);
      
      $_POST['id']=0;
      $msgSalv="Le modifiche sono state salvate.";
    }
}

// leggi db
    $totTelef=0;
    $telef=array(
	"id" => array (""),
	"tipo" => array (""),
	"numero" => array (""),
	"nota" => array ("")
    );

    $sql="SELECT id,tipo,numero,nota FROM vetrine_telefoni WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $telef['id'][]=$q['id'];
    $telef['tipo'][]=$q['tipo'];
    $telef['numero'][]=$q['numero'];
    $telef['nota'][]=$q['nota'];
    $totTelef++;
    }


// struttura html
$title="Admin ".$attivita." - Contatti telefonici";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Contatti telefonici</h4><br />
<?php
if ($totTelef>0) {
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {

    for ($i=1;$i<count($telef['id']);$i++) {
        print "<h5>Numero: ".$i." di ".$totTelef."</h5>";
        print "<form id='modifTelef_".$telef['id'][$i]."' method='post' action='?' class='riquadro'>";
        print "<p><label>Tipo e Numero</label><br />";
        
        print "<select name='newTipo' option='1'>";
        print "<option value='Tel.'"; if ( $telef['tipo'][$i]=="Tel.") { print " selected";}  print ">Tel.</option>";
        print "<option value='Cell.'"; if ( $telef['tipo'][$i]=="Cell.") { print " selected";}  print ">Cell.</option>";
        print "<option value='Fax'"; if ( $telef['tipo'][$i]=="Fax") { print " selected";}  print ">Fax</option>";
        print "</select> &nbsp;&nbsp;";
                
        print "<input type='text' id='tel' size='20' name='newNumero' value='".$telef['numero'][$i]."' pattern='[0-9]{3,30}' /></p>";
        print "<p><label>Nota</label><br />";
        print "<textarea name='newNota' rows='1' cols='30'>".$telef['nota'][$i]."</textarea></p>";
        print "<p><label>Rimuovere questo numero?</label><br />";
        print "<select name='rimoz' option='1'>";
        print "<option value='n' selected>No, confermalo</option>";
        print "<option value='s'>S&igrave;, rimuovilo dal database</option>";
        print "</select><br /><br /></p>";

        print "<input type='hidden' name='id' value='".$telef['id'][$i]."'/>";
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
<h5 class="verde">Aggiungi un numero</h5>
<form id="nuovoTelef" method="post" action="?">

  <p><label>Seleziona il tipo<label><br />
  <select name="newTipo" option="1">
  <option value="Tel." selected>Telefono fisso</option>
  <option value="Fax">Fax</option>
  <option value="Cell.">Cellulare/Mobile</option>
  </select><br /><br /></p>
  
  <p><label>Numero<label><br />
  <input type="text" size="30" name="newNumero" value="" pattern="[0-9]{3,30}" required /><br /><br /></p>
  
  <p><label>Nota al numero<label><br />  
  <textarea name="newNota" rows="3" cols="30"></textarea><br /><br /></p> 

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettato, il <b>Numero</b> deve essere formato da 3 a 30 caratteri numerici (senza punti, virgole o altre forme di separazione). La <b>Nota</b> pu&ograve; essere usata per aggiungere informazioni utili quali p.es. gli orari, la persona a cui appartiene il numero ecc.; se pubblicata, la Nota sar&agrave; visibile a tutti accanto al numero.</p>
<p>Campi obbligatori: Numero e Tipo.</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
