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
if ($_POST['newPwd']=="" | $_POST['confPwd']==""){
$msgErr="Dati mancanti o non inseriti";
}
if ($_POST['confPwd']!=$_POST['newPwd']){
$msgErr="Password non confermata!";
}
if ($msgErr==""){
$msgErr=$myobj->ctrlSegr($_POST['newPwd'],"5","15");
}

// SALVATAGGIO
if ($msgErr==""){
      $sql="UPDATE att_clienti SET 
	  pwd='".mysqli_real_escape_string($conn,stripslashes($_POST['newPwd']))."'
	  WHERE idAttivita='".$idAttivita."'";
      print $sql;
/*
      $query=mysqli_query($conn,$sql);
      
      $_SESSION['pwd']=$_POST['newPwd']; 
      $pwd=$_POST['newPwd'];
*/      
      $_POST['upd']="n";
      $msgSalv="ok";
}
}

// struttura html
$title="Admin ".$attivita." - Password";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Modifica password</h4><br />
<?php
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {
?>
<form id="password" method="post" action="?">

  <p><label>Attuale nomew utente<label><br />
  <input type="text" size="30" name="disUt" value="<?php print $utente; ?>" disabled="yes" class="disabled" /></p>

  <p><label>Attuale password<label><br />
  <input type="text" size="30" name="disPwd" value="<?php print $pwd; ?>" disabled="yes" class="disabled" /></p>

  <p><label>Imposta una nuova password<label><br />
  <input type="text" size="30" name="newPwd" id="password" required value="" autofocus /></p>
  <p><label for="password">Riscrivi e conferma la nuova password<label><br />  
  <input type="password" id="password" size="30" name="confPwd" value="" required /></p>

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
<p class="testo">La <b>password</b> deve essere formata da caratteri alfanumerici (numeri e lettere maiuscole e/o minuscole) per un totale non inferiore a 5 e non superiore a 15.<br /><br /> Contattare <i>Promogenova.it</i> se si desidera cambiare anche il proprio <b>nome utente</b>.
</p>
<p>Campi obbligatori: tutti.</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
