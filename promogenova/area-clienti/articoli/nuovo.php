<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

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
        $sqldopp="SELECT titolo FROM articoli WHERE titolo LIKE '".$_POST['art_titolo']."'";
        $querydopp=@mysqli_query($conn,$sqldopp);
        $dopp=@mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
        if ($dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo titolo!"; }
    }
    if ($msgErr==""){
        $sqldopp="SELECT titolo FROM articoli WHERE titolo LIKE '".$new_titolo."'";
        $querydopp=@mysqli_query($conn,$sqldopp);
        $dopp=@mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
        if ($dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo titolo!"; }
    }

// SALVATAGGIO IN SESSIONE
    if ($msgErr==""){

      $art_titolo=$myobj->convTitle($_POST['art_titolo']); // formatta titolo
      $_SESSION['art_titolo']=$art_titolo; $_POST['art_titolo']=$art_titolo;
      $_POST['upd']="n";

      // passa automaticamente al prossimo step
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-testo.php';\n"; 
  echo "</script>"; 
    }
}

// struttura html
$title="Admin ".$attivita." - Nuovo articolo - Step 1 di 5: Titolo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Articolo - Passaggio 1 di 5: Titolo</h4>

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
?>
<form id="nuovo00" method="post" action="?">

  <p><label for="titoloArt">Titolo dell'Articolo<label><br />
  <textarea name="art_titolo" id="titoloArt" rows="5" cols="30" autofocus required><?php print $art_titolo; ?></textarea></p><br /> <!-- pattern="[a-zA-Z]{3,120}" -->

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<p>Torna al <a href="index.php">Menu articoli</a> | Torna all'<a href="../">Inizio</a></p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Inserisci un <b>Titolo</b> che sia composto di da <span class="rosso">almeno 1 parola</span> di 3 caratteri e/o una frase di non pi&ugrave; di <span class="rosso">120 caratteri complessivi</span>. Attenzione: sono consentiti unicamente caratteri alfanumerici (ossia lettere e numeri, non sono ammessi caratteri speciali quali il simbolo dell'euro ecc.), mentre i testi in maiuscolo saranno riformattati tutti in minuscolo.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br />
<h5 class="arancio">Creare un articolo passo dopo passo</h5>
<p>La creazione di nuovi articoli - come vedi -  viene accompagnata sempre passo dopo passo da istruzioni e suggerimenti utili. Nell'ultimo passaggio ti verr&agrave; offerta un'anteprima di tutti i dati inseriti in base alla quale potrai valutare se e come pubblicare il Nuovo articolo.</p>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
