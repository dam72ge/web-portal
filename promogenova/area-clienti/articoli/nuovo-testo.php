<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// reg su db
$msgErr="";
if (isset($_POST['upd']) && $_POST['upd']!="n") {
$new_testo=$mysql->formattaTxt($_POST['art_testo']);
    
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
        $sqldopp="SELECT testo FROM articoli_txt WHERE testo LIKE '".mysqli_real_escape_string($conn,$new_testo)."'";
        $querydopp=mysqli_query($conn,$sqldopp);
        $dopp=mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
    if (isset($dopp['testo']) && $dopp['testo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo testo!"; }
    }


// SALVATAGGIO IN SESSIONE
    if ($msgErr==""){

      //$art_testo=$_POST['art_testo'];
      //$art_testo=$myobj->formatta($_POST['art_testo']); // formatta testo
      //$_SESSION['art_testo']=$art_testo; $_POST['art_testo']=$art_testo;
      $_SESSION['art_testo']=$new_testo; $art_testo=$new_testo; $_POST['art_testo']=$new_testo;
      $_POST['upd']="n";
      
      // passa automaticamente al prossimo step
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-immagine.php';\n"; 
  echo "</script>"; 
      //header("location: nuovo-immagine.php");
    }
}

// struttura html
$title="Admin ".$attivita." - Nuovo articolo - Step 2 di 5: Testo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Articolo - Passaggio 2 di 5: Testo</h4>
<?php
if ($_SESSION['art_titolo']!="" && $_SESSION['art_testo']!="" && $_SESSION['art_idMacro']>0){ 
?>
<a href="nuovo.php">1 Titolo</a> | 
<a href="nuovo-testo.php">2 Testo</a> | 
<a href="nuovo-immagine.php">3 Immagine</a> | 
<a href="nuovo-categoria.php">4 Categoria comm.le</a> | 
<a href="nuovo-pubblica.php">5 Anteprima e Pubblicazione</a>
<br />
<?php    
}
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}
$art_testo=$myobj->mb_convert_encoding($art_testo);
$totParole=str_word_count($art_testo);
?>
<form id="nuovo00" method="post" action="?">

  <p><label for="testoArt">Testo dell'Articolo (<?php print $totParole;?> parole)<label><br />
  <textarea name="art_testo" id="testoArt" rows="10" cols="30" autofocus required><?php print $art_testo; ?></textarea></p>

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<p>Torna al <a href="index.php">Menu articoli</a> | Torna all'<a href="../">Inizio</a></p>
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
