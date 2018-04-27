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
    
      $sql="UPDATE att_clienti_contatti SET 
	  telefono='".mysqli_real_escape_string($conn,stripslashes($_POST['newTel']))."',
	  email='".mysqli_real_escape_string($conn,stripslashes($_POST['newEmail']))."',
	  nota='".mysqli_real_escape_string($conn,stripslashes($_POST['newNota']))."'
	  WHERE idAttivita='".$idAttivita."'";
      $query=mysqli_query($conn,$sql);
      
      $_SESSION['clienteTel']=$_POST['newTel']; 
      $clienteTel=$_POST['newTel'];
      $_SESSION['clienteEmail']=$_POST['newEmail']; 
      $clienteEmail=$_POST['newEmail'];
      $_SESSION['clienteNota']=$_POST['newNota']; 
      $clienteNota=$_POST['newNota'];
      
      $_POST['upd']="n";
      $msgSalv="ok";
}

// struttura html
$title="Admin ".$attivita." - Dati riservati";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Dati riservati</h4><br />

<?php
if ($msgSalv=="") {
?>
<form id="datiriservati" method="post" action="?">
  <p><label>Telefono<label><br />
  <input type="text" size="30" name="newTel" value="<?php print $clienteTel; ?>" /></p>
  <p><label for="email">E-mail<label><br />
  <input type="text" id="email" size="30" name="newEmail" value="<?php print $clienteEmail; ?>" /></p>
  <p><label>Nota personale<label><br />  
  <textarea name="newNota" rows="4" cols="30" ><?php print $clienteNota; ?></textarea></p>
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
<p class="testo">I tuoi <em>Dati riservati</em> possono venire utilizzati da Promogenova per contattarti direttemente. Non saranno pubblicati in alcun modo.</p>
<p>Campi obbligatori: nessuno.</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
