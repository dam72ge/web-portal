<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
$msgSalv="";
if (isset($_POST['upd']) && $_POST['upd']!="n") {
    
// CONTROLLI
if ($_POST['newPIVA']=="" && $_POST['newCF']==""){
$msgErr="E' obbligatorio inserire almeno uno dei due campi.";
}

// SALVATAGGIO
if ($msgErr==""){
      $sql="UPDATE att_ragsoc SET 
	  partitaiva='".mysqli_real_escape_string($conn,stripslashes($_POST['newPIVA']))."',
	  codfisc='".mysqli_real_escape_string($conn,stripslashes($_POST['newCF']))."'
	  WHERE idAttivita='".$idAttivita."'";
      $query=mysqli_query($conn,$sql);
      
      $_SESSION['partitaiva']=$_POST['newPIVA'];  $partitaiva=$_POST['newPIVA'];
      $_SESSION['codfisc']=$_POST['newCF'];  $codfisc=$_POST['newCF'];
      
      $_POST['upd']="n";
      $msgSalv="ok";
}
}

// struttura html
$title="Admin ".$attivita." - Partita IVA e Codice Fiscale";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Partita IVA e/o Codice Fiscale</h4><br />
<?php
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {
?>
<form id="pivacodfisc" method="post" action="?">

  <p><label>Partita IVA<label><br />
  <input type="text" size="30" name="newPIVA" value="<?php print $partitaiva; ?>" autofocus pattern="[0-9]{11,11}" /></p>
  <p><label>Codice fiscale<label><br />  
  <input type="text" size="30" name="newCF" value="<?php print $codfisc; ?>" pattern="[0-9A-Z]{7,20}" /></p> 

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<?php
}
else{
print "<h2 class='verde'>I dati sono stati salvati.</h2>";
print "<a href='../'>Torna al Men&ugrave; principale</a> oppure <a href='?'>Modifica di nuovo.</a><br /><br />";	
}
?>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettata, la <b>Partita IVA</b> deve essere formata da una serie di 11 numeri. Il <b>Codice fiscale</b> &egrave; invece composto da una sequenza di 16 caratteri alfanumerici (numeri e lettere maiuscole).</p>
<p>Campi obbligatori: almeno uno dei due va compilato.</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
