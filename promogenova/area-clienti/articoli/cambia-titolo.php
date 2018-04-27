<?php
// idArt
if (!isset($_GET['idArt'])) {
header ("location: index.php");
}
$idArt=$_GET['idArt'];

// redirect finale
$redirUrl="articoliModif.php?idArt=".$idArt;

$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// riconosci cliente
$cfrAtt=$mysql->cliente_articolo($conn,$idArt);
if ($idAttivita!=$cfrAtt) {
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
}

// reg su db
$msgErr="";
if (isset($_POST['upd']) && $_POST['upd']!="n") {
$new_titolo=$myobj->convTitle($_POST['art_titolo']); // formatta testo

    // CONTROLLI
    if ($new_titolo==""){
    $msgErr="Il campo non pu&ograve; essere lasciato vuoto.";
    }

    if ($msgErr=="") { $msgErr=$myobj->contaCaratteri($new_titolo,3,120); }
    if ($msgErr=="") { $msgErr=$myobj->minimoParole($new_titolo,1); }
    if ($msgErr=="") { $msgErr=$myobj->checkTag($new_titolo); }
    if ($msgErr=="") { $msgErr=$myobj->checkMaiu($new_titolo); }
    // no doppioni
    if ($msgErr==""){
        $sqldopp="SELECT titolo FROM articoli WHERE titolo LIKE '".mysqli_real_escape_string($conn,stripslashes($_POST['art_titolo']))."' AND idArt!='".$idArt."'";
        $querydopp=mysqli_query($conn,$sqldopp);
        $dopp=mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
    if (isset($dopp['titolo']) && $dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo titolo!"; }
    }
    if ($msgErr==""){
        $sqldopp="SELECT titolo FROM articoli WHERE titolo LIKE '".$new_titolo."' AND idArt!='".$idArt."'";
        $querydopp=mysqli_query($conn,$sqldopp);
        $dopp=mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
    if (isset($dopp['titolo']) && $dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo titolo!"; }
    }

// SALVATAGGIO IN SESSIONE
    if ($msgErr==""){

      $art_titolo=$myobj->convTitle($_POST['art_titolo']); // formatta testo
      $_SESSION['art_titolo']=$art_titolo; $_POST['art_titolo']=$art_titolo;
      $_POST['upd']="n";
      
            $sql="UPDATE articoli SET  
            titolo='".mysqli_real_escape_string($conn,stripslashes($art_titolo))."' 
            WHERE idArt='".$idArt."'";
            $query=mysqli_query($conn,$sql);
      
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
    }
}

// struttura html
$title="Admin ".$attivita." - Articolo ".$idArt." - ".$_SESSION['art_titolo']." - Modifica titolo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica il titolo dell'articolo n.ro <?php print $idArt; ?></h3><br />
<br />
<?php

if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}
?>
<form id="nuovo00" method="post" action="?idArt=<?php print $idArt; ?>">

  <p><label for="titoloArt">Titolo dell'Articolo<label><br />
  <textarea name="art_titolo" id="titoloArt" rows="5" cols="30" autofocus required><?php print $_SESSION['art_titolo']; ?></textarea></p>

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<p>
Per tornare al Men&ugrave; dell'Articolo clicca <a href="<?php print $redirUrl; ?>">QUI</a> oppure sul bottone SALVA.
</p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Inserisci un <b>Titolo</b> che sia composto di da <span class="rosso">almeno 1 parola</span> di 3 caratteri e/o una frase di non pi&ugrave; di <span class="rosso">120 caratteri complessivi</span>. Attenzione: sono consentiti unicamente caratteri alfanumerici (ossia lettere e numeri, non sono ammessi caratteri speciali quali il simbolo dell'euro ecc.), mentre i testi in maiuscolo saranno riformattati tutti in minuscolo.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br />
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
