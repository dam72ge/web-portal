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
if ($_POST['newRagSoc']==""){
$msgErr="Il campo non pu&ograve; essere lasciato vuoto.";
}
if ($msgErr=="") { $msgErr=$myobj->contaCaratteri($_POST['newRagSoc'],3,255); }
if ($msgErr=="") { $msgErr=$myobj->minimoParole($_POST['newRagSoc'],1); }

// SALVATAGGIO
if ($msgErr==""){
      $sql="UPDATE att_ragsoc SET 
	  ragsoc='".mysqli_real_escape_string($conn,stripslashes($_POST['newRagSoc']))."' 
	  WHERE idAttivita='".$idAttivita."'";
      $query=mysqli_query($conn,$sql);
      
      $_SESSION['ragsoc']=$_POST['newRagSoc'];  $ragsoc=$_POST['newRagSoc'];
      
      $_POST['upd']="n";
      $msgSalv="ok";
}
}

// struttura html
$title="Admin ".$attivita." - Tipo di Attivit&agrave; e/o Ragione sociale";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Tipo di Attivit&agrave;</h4><br />
<?php
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {
?>
<form id="pivacodfisc" method="post" action="?">

  <p><label>Tipo di Attivit&agrave;<label><br />
  <textarea name="newRagSoc" rows="5" cols="40" autofocus required><?php print $ragsoc; ?></textarea></p>

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
<p class="testo">Il <b>Tipo di Attivit&agrave;</b> pu&ograve; riportare per esteso la sigla, parola o frase che costituisce la tua ragione sociale, oppure una <span class="verde">definizione sintetica</span> della tua professione, di ci&ograve; che fai, di cosa ti occupi ecc.. Per esempio: <em>Ristorante dei F.lli Tizio Caio & Sempronio Srl</em>, oppure <em>Ristorante - Cucina italiana e regionale</em>.<br /> Attenzione: il testo deve essere composto da <span class="rosso">almeno 1 parola</span> di 3 caratteri e/o una frase di non pi&ugrave; di <span class="rosso">255 caratteri complessivi</span>.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
