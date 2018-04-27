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
    if ($_POST['newMarchio']==""){
    $msgErr="Devi inserire un marchio.";
    }

    // SALVATAGGIO
    if ($msgErr==""){

    $sql = 
    "
    INSERT INTO vetrine_marchi 
    (id,idAttivita,marchio) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newMarchio']))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovoINS=mysqli_insert_id($conn);
      
    $_POST['upd']="n";
    $msgSalv="Il marchio &egrave; stato aggiunto.";
    }
}

// ELIMINA NUMERO
if (isset($_POST['rimoz']) && $_POST['rimoz']=="s") {
   $sql="DELETE FROM vetrine_marchi WHERE id='".$_POST['id']."'"; 
   $query=mysqli_query($conn,$sql);
   
   $_POST['id']=0;
   $msgSalv="Il marchio &egrave; stato rimosso.";
}


// MODIFICA NUMERO
if (isset($_POST['id']) && $_POST['id']>0) {
    
    // controllo
    if ($_POST['newMarchio']==""){
    $msgErr="Devi inserire il marchio.";
    }

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine_marchi SET 
	  marchio='".mysqli_real_escape_string($conn,stripslashes($_POST['newMarchio']))."'
	  WHERE id='".$_POST['id']."'";
      $query=mysqli_query($conn,$sql);
      
      $_POST['id']=0;
      $msgSalv="Le modifiche sono state salvate.";
    }
}

// leggi db
    $totMarchi=0;
    $marchi=array(
	"id" => array (""),
	"marchio" => array ("")
    );

    $sql="SELECT id,marchio FROM vetrine_marchi WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $marchi['id'][]=$q['id'];
    $marchi['marchio'][]=$q['marchio'];
    $totMarchi++;
    }


// struttura html
$title="Admin ".$attivita." - Marchi";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Marchi</h4><br />
<?php
if ($totMarchi>0) {
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {

    for ($i=1;$i<count($marchi['id']);$i++) {
        print "<h5>Marchio: ".$i." di ".$totMarchi."</h5>";
        print "<form id='modifMarchi_".$marchi['id'][$i]."' method='post' action='?' class='riquadro'>";
        
        $nome=$myobj->mb_convert_encoding($marchi['marchio'][$i]);
        print "<p><label>Marchio</label><br /> ";    
        print "<input type='text' size='20' name='newMarchio' value='".$nome."' /></p>";

        print "<p><label>Rimuovere questa marchio?</label><br />";
        print "<select name='rimoz' option='1'>";
        print "<option value='n' selected>No, confermala</option>";
        print "<option value='s'>S&igrave;, rimuovila dal database</option>";
        print "</select></p><br />";

        print "<input type='hidden' name='id' value='".$marchi['id'][$i]."'/>";
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
<h5 class="verde">Aggiungi un Marchio</h5>
<form id="nuovaMarchio" method="post" action="?">

  <p><label>Marchio<label><br />
  <input type="text" size="30" name="newMarchio" value="" required /><br /><br /></p>
  
  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">L'aggiunta dei <b>Marchi</b> che tratti pu&ograve; agevolare il visitatore del portale nella ricerca della tua Attivit&agrave;. Per essere accettata, ogni singolo <b>Marchio</b> deve essere formato da una o pi&ugrave; parole che non superino complessivamente <span class="rosso">255 caratteri</span>. </p>
<p>Campi obbligatori: nessuno. L'inserimento dei marchi &egrave; facoltativo.</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
