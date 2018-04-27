<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
$msgSalv="";
if (isset($_POST['upd']) && $_POST['upd']!="n" && $_POST['chisiamo']!=$chisiamo) {

    // minimo parole in un testo (testo, minimo)
    if ($msgErr=="") { $msgErr=$myobj->minimoParole($_POST['chisiamo'],15); }
    if ($msgErr=="") { $msgErr=$myobj->massimoParole($_POST['chisiamo'],150); }
    
//print $msgErr; exit;
    if ($msgErr=="" && $_POST['chisiamo']!=$chisiamo) {
      $sql="UPDATE vetrine_chisiamo SET 
	  chisiamo='".mysqli_real_escape_string($conn,stripslashes($_POST['chisiamo']))."' 
	  WHERE idAttivita='".$idAttivita."'"; 
      $query=mysqli_query($conn,$sql);
      
      $_SESSION['chisiamo']=$_POST['chisiamo']; 
      $chisiamo=$_POST['chisiamo'];      
      $_POST['upd']="n";
      $msgSalv="ok";
      }

}

// struttura html
$title="Admin ".$attivita." - Chi siamo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Chi siamo</h4><br />

<?php
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {
//$testo=$myobj->mb_convert_encoding($chisiamo);
$testo=$chisiamo;
$totParole=str_word_count($testo);

//Per saperne di più: http://www.iprog.it/blog/php-2/script-php-per-contare-le-parole-contenute-in-un-testo/ | iProg
?>
<form id="chisiamo" method="post" action="?">
  <p><label>Testo (<?php print $totParole;?> parole)<label><br />  
  <textarea name="chisiamo" rows="10" cols="30" ><?php print $testo; ?></textarea></p>
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
<p class="testo">Nella sezione <b><span class='verde'>Chi siamo</span></b> vengono fornite ai visitatori le notizie <strong>essenziali</strong> sulla tua Attivit&agrave;. Hai a disposizione <span class="rosso">non meno di 15</span> e <span class="rosso">non pi&ugrave; di 150 parole</span> per raccontarti in maniera efficace e chiara.</p>
<p>Campi obbligatori: testo.</p>
<br /><br /><br />

<p><h5 class="arancio">Esempio di presentazione <em>standard</em></h5>
L'<?php print ucwords($attivita); ?> &egrave; presente a <?php print ucwords($comune); ?> [+QUARTIERE] dal [ANNO], si occupa di <?php print strtolower($ragsoc); ?>... e si rivolge a...<br /><br />
La gamma dei prodotti/servizi trattati riguarda: ...<br /><br />
Vicinanza Stazioni ferroviarie, disponibilit&agrave; parcheggi e mezzi pubblici: ...<br />
<br /><br /><br /><br /><br />
</p>
</div>
</div>
<?php
include "../footer.php";
?>
