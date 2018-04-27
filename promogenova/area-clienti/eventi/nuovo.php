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
$new_titolo=$myobj->convTitle($_POST['ev_titolo']); // formatta testo
    
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
        $sqldopp="SELECT titolo FROM eventi WHERE titolo LIKE '".$_POST['ev_titolo']."'";
        $querydopp=@mysql_query($sqldopp);
        $dopp=@mysql_fetch_array($querydopp);
        if ($dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un evento con questo titolo!"; }
    }
    if ($msgErr==""){
        $sqldopp="SELECT titolo FROM eventi WHERE titolo LIKE '".$new_titolo."'";
        $querydopp=@mysql_query($sqldopp);
        $dopp=@mysql_fetch_array($querydopp);
        if ($dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un evento con questo titolo!"; }
    }

// SALVATAGGIO IN SESSIONE
    if ($msgErr==""){

      $ev_titolo=$myobj->convTitle($_POST['ev_titolo']); // formatta testo
      //$ev_titolo=$myobj->formatta($_POST['ev_titolo']); // formatta testo
      $_SESSION['ev_titolo']=$ev_titolo; $_POST['ev_titolo']=$ev_titolo;
      $_POST['upd']="n";
      
      // passa automaticamente al prossimo step
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-date.php';\n"; 
  echo "</script>"; 
      
      //header("location: nuovo-date.php");
    }
}

// struttura html
$title="Admin ".$attivita." - Nuovo evento - Step 1 di 6: Titolo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Evento - Passaggio 1 di 6: Titolo</h4>
<?php
if ($_SESSION['ev_titolo']!="" && $_SESSION['ev_testo']!=""){ 
?>
<a href="nuovo.php">1 Titolo</a> | 
<a href="nuovo-date.php">2 Date</a> | 
<a href="nuovo-luogo.php">3 Luogo</a> | 
<a href="nuovo-testo.php">4 Testo</a> | 
<a href="nuovo-immagine.php">5 Immagine</a> | 
<a href="nuovo-pubblica.php">6 Anteprima e Pubblicazione</a>
<br />
<?php
}
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}
?>
<form id="nuovoevTitolo" method="post" action="?">

  <p><label for="titoloEv">Titolo dell'Evento<label><br />
  <textarea name="ev_titolo" id="titoloEv" rows="5" cols="30" autofocus required><?php print $ev_titolo; ?></textarea></p>

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<p>Torna al <a href="index.php">Menu eventi</a> | Torna all'<a href="../">Inizio</a></p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Inserisci un <b>Titolo</b> che sia composto di da <span class="rosso">almeno 1 parola</span> di 3 caratteri e/o una frase di non pi&ugrave; di <span class="rosso">120 caratteri complessivi</span>. Attenzione: sono consentiti unicamente caratteri alfanumerici (ossia <span class="rosso">soltanto lettere e numeri</span>, non sono ammessi caratteri speciali quali il simbolo dell'euro ecc.), mentre i testi in maiuscolo saranno riformattati tutti in minuscolo.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br />
<h5 class="arancio">Creare un evento passo dopo passo</h5>
<p>La creazione di nuovi eventi - come vedi -  viene accompagnata sempre passo dopo passo da istruzioni e suggerimenti utili. Nell'ultimo passaggio ti verr&agrave; offerta un'anteprima di tutti i dati inseriti in base alla quale potrai valutare se e come pubblicare il Nuovo evento.</p>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
