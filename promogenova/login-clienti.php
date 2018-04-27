<?php
$url=""; 
include "config/mydb.php";
session_start();

// carica elenchi
//$promo=$mysql->elenco_promo();
//$eventi=$mysql->eventi();
//$vetrine=$mysql->vetrine();

// struttura html
$title="Area clienti";
$metaDescription="";
$metaKeywords="";
$metaRobots="NO";

include "config/head.php";
include "config/header-nav.php";
?>

<div class="riga">
<div class="colonna-1" style="text-align:center">
<br/><br/><br/>

<?php
if (isset($_SESSION['idAttivita']) && isset($_SESSION['utente'])){
print "<h3>Ciao, ".$_SESSION['utente']."!</h3><br /><br />";
print "Hai gi&agrave; inserito il tuo nome e la tua <i>password</i>, per cui risulti ancora <i>loggato</i> nell'<b>Area Clienti</b>.
<br /><br />Puoi dunque <a href='area-clienti/index.php'>continuare nella gestione dei tuoi spazi</a> e del tuo <i>account</i> sul Portale, oppure puoi <a href='area-clienti/logout.php'>cliccare QUI per chiudere</a> il Pannello di amministrazione.";
	} else {
?>


  <form id="logVetr" method="post" action="<?php print $url; ?>area-clienti/login-controllo.php">
  <p>
  <label>Nome utente<label><br/>
  <input type="text" size="25" name="utente" value="" class="riqInput" style="width:200px" /><br/>
  </p>
  <p>
  <label>Password<label><br/>
  <input type="password" size="25" name="pwd" value="" class="riqInput" style="width:200px" /><br/>
  </p>
  <br/>
  <input type="submit" name="trova" value=" ENTRA " class="bottSubmit" style="width:200px" />
  <form>

<?php
}
?>

  <br/><br/><br/>
  <br/><br/><br/>
  <br/><br/><br/>


</div>
</div>

<?php
include "config/footer.php";
?>
