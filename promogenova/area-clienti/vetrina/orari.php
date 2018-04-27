<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
$msgSalv="";
if (isset($_POST['upd']) && $_POST['upd']!="n" && $_POST['orari']!=$orari) {

    // minimo parole in un testo (testo, minimo)
    if ($msgErr=="") { $msgErr=$myobj->massimoParole($_POST['orari'],50); }
    
//print $msgErr; exit;
    if ($msgErr=="" && $_POST['orari']!=$orari) {
      $sql="UPDATE vetrine_orari SET 
	  orari='".mysqli_real_escape_string($conn,stripslashes($_POST['orari']))."' 
	  WHERE idAttivita='".$idAttivita."'"; 
      $query=mysqli_query($conn,$sql);
      
      $_SESSION['orari']=$_POST['orari']; 
      $orari=$_POST['orari'];      
      $_POST['upd']="n";
      $msgSalv="ok";
      }

}

// struttura html
$title="Admin ".$attivita." - Orari";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Orari</h4><br />

<?php
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {
//$testo=$myobj->mb_convert_encoding($orari);
$testo=$orari;
$totParole=str_word_count($testo);

//Per saperne di più: http://www.iprog.it/blog/php-2/script-php-per-contare-le-parole-contenute-in-un-testo/ | iProg
?>
<form id="orari" method="post" action="?">
  <p><label>Testo (<?php print $totParole;?> parole)<label><br />  
  <textarea name="orari" rows="10" cols="30" ><?php print $testo; ?></textarea></p>
  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<?php
}
else{
print "<h2 class='verde'>I dati sono stati salvati.</h2>";
print "<a href='?'>Clicca qui</a> se desideri modificarli ancora<br />";
}
?>
<p>Torna all'<a href="../">Inizio</a></p>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Nella sezione <b><span class='verde'>Orari</span></b> hai a disposizione <span class="rosso">non pi&ugrave; di 50 parole</span> per dare a visitatori e clienti notizie <strong>indicative</strong> inerenti all'apertura e alla chiusura settimanali del tuo negozio, oppure per informare sulla tua disponibilit&agrave; (le fasce orarie in cui sei rintracciabile o contattabile).</p>
<p>Campi obbligatori: nessuno.</p>
<br /><br /><br />

<br /><br /><br /><br /><br />
</p>
</div>
</div>
<?php
include "../footer.php";
?>
