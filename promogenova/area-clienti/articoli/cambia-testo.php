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
$new_testo=$mysql->formattaTxt($_POST['art_testo']);
// $new_testo=$_POST['art_testo'];
 
    // CONTROLLI
    if ($new_testo==""){
    $msgErr="Il campo non pu&ograve; essere lasciato vuoto.";
    }
    if ($msgErr=="") { $msgErr=$myobj->minimoParole($new_testo,5); }
    if ($msgErr=="") { $msgErr=$myobj->checkMaiu($new_testo); }

	// codici html (ammessi tutti tranne div, form, php...)
    if ($msgErr=="") { $msgErr=$myobj->checkHtml($new_testo); }

    // no doppioni
    if ($msgErr==""){
        $sqldopp="SELECT testo FROM articoli_txt WHERE testo LIKE '".mysqli_real_escape_string($conn,$new_testo)."' AND idArt!='".$idArt."'";
        $querydopp=mysqli_query($conn,$sqldopp);
        $dopp=mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
        if ($dopp['testo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo testo!"; }
    }


// SALVATAGGIO IN SESSIONE
    if ($msgErr==""){

      //$art_testo=$_POST['art_testo']; // formatta testo
      //$art_testo=$myobj->formatta($_POST['art_testo']); // formatta testo
      //$_SESSION['art_testo']=$art_testo; $_POST['art_testo']=$art_testo;
      $_SESSION['art_testo']=$new_testo; $art_testo=$new_testo; $_POST['art_testo']=$new_testo;
      $_POST['upd']="n";
      
            $sql="UPDATE articoli_txt SET  
            testo='".mysqli_real_escape_string($conn,stripslashes($new_testo))."' 
            WHERE idArt='".$idArt."'";
            $query=mysqli_query($conn,$sql);

      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
    }
}

// struttura html
$title="Admin ".$attivita." - Articolo ".$idArt." - ".$_SESSION['art_titolo']." - Modifica testo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica il testo dell'articolo n.ro <?php print $idArt; ?></h3><br />
<br />
<?php
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}
$art_testo=$myobj->mb_convert_encoding($art_testo);
$totParole=str_word_count($art_testo);
?>
<form id="nuovo00" method="post" action="?idArt=<?php print $idArt; ?>">

  <p><label for="testoArt">Testo dell'Articolo (<?php print $totParole;?> parole)<label><br />
  <textarea name="art_testo" id="testoArt" rows="10" cols="30" autofocus required><?php print $_SESSION['art_testo']; ?></textarea></p>

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<p>
Per tornare al Men&ugrave; dell'Articolo clicca <a href="<?php print $redirUrl; ?>">QUI</a> oppure sul bottone SALVA.
</p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Inserisci un <b>Testo</b> che sia composto di da <span class="rosso">almeno 5 parole</span>. Nel campo <b>testo</b> puoi descrivere o presentare con parole semplici il tuo prodotto, il servizio, il corso o la prestazione professionale che intendi pubblicizzare; nel farlo, &egrave; consigliabile riprendere e sviluppare ulteriormente quanto suggerito dal titolo, aggiungendo pi&ugrave; particolari che possano catturare l'attenzione del visitatore (quali l'eventuale prezzo, la disponibilit&agrave; dell'articolo in negozio, le modalit&agrave; di prenotazione e quelle di pagamento, ecc.). Attenzione: <span class="rosso">sono consentiti unicamente caratteri alfanumerici</span> (non sono ammessi caratteri speciali quali il simbolo dell'euro ecc.), mentre i testi tutti in maiuscolo saranno riformattati in minuscolo.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
