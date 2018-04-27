<?php
// id
if (!isset($_GET['id'])) {
header ("location: index.php");
}
$id=$_GET['id'];

// redirect finale
$redirUrl="eventiModif.php?id=".$id;

$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// riconosci cliente
$cfrAtt=$mysql->cliente_eventi($conn,$id,$idAttivita);
if ($idAttivita!=$cfrAtt) {
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
}


// reg su db
$msgErr="";
if (isset($_POST['upd']) && $_POST['upd']!="n") {
$new_testo=$mysql->formattaTxt($_POST['ev_testo']);
    
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
        $sqldopp="SELECT testo FROM eventi_txt WHERE testo LIKE '".mysqli_real_escape_string($conn,stripslashes($new_testo))."'";
        $querydopp=mysql_query($sqldopp);
        $dopp=mysql_fetch_array($querydopp);
        if (isset($dopp['testo']) && $dopp['testo']!=""){ $msgErr="Esiste gi&agrave; un evento con questo testo!"; }
    }
    if ($msgErr==""){
        $sqldopp="SELECT testo FROM eventi_txt WHERE testo LIKE '".mysqli_real_escape_string($conn,stripslashes($_POST['ev_testo']))."'";
        $querydopp=mysql_query($sqldopp);
        $dopp=mysql_fetch_array($querydopp);
        if (isset($dopp['testo']) && $dopp['testo']!=""){ $msgErr="Esiste gi&agrave; un evento con questo testo!"; }
    }


// SALVATAGGIO IN SESSIONE
    if ($msgErr==""){

      //$ev_testo=$_POST['ev_testo'];
      //$ev_testo=$myobj->formatta($_POST['ev_testo']); // formatta testo
      //$_SESSION['ev_testo']=$ev_testo; $_POST['ev_testo']=$ev_testo;
      //$_POST['upd']="n";

      $_SESSION['ev_testo']=$new_testo; $ev_testo=$new_testo; $_POST['ev_testo']=$new_testo;
      $_POST['upd']="n";
      
            $sql="UPDATE eventi_txt SET  
            testo='".mysqli_real_escape_string($conn,stripslashes($new_testo))."' 
            WHERE id='".$id."'";
            $query=mysqli_query($conn,$sql);
      
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
    }
}

// struttura html
$title="Admin ".$attivita." - Evento ".$id." - Modifica testo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica il testo dell'evento n.ro <?php print $id; ?></h3><br />
<br />
<?php
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}
$ev_testo=$myobj->mb_convert_encoding($ev_testo);
$totParole=str_word_count($ev_testo);
?>
<form id="nuovo00" method="post" action="?id=<?php print $id; ?>">

  <p><label for="testoEv">Testo dell'Evento (<?php print $totParole;?> parole)<label><br />
  <textarea name="ev_testo" id="testoEv" rows="10" cols="30" autofocus required><?php print $ev_testo; ?></textarea></p>

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<p><a href="<?php print $redirUrl; ?>">Torna all'Evento</a></p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Inserisci un <b>Testo</b> che sia composto di da <span class="rosso">almeno 5 parole</span>. Nel campo <b>testo</b> puoi descrivere o presentare con parole semplici l'evento che intendi pubblicizzare; nel farlo, &egrave; consigliabile riprendere e sviluppare ulteriormente quanto suggerito dal titolo, aggiungendo pi&ugrave; particolari che possano catturare l'attenzione del visitatore o di chi potrebbe partecipare (ulteriori e dettagliate informazioni sul luogo e su come raggiungerlo, l'eventuale prezzo di ingresso, l'orario di svolgimento, le possibilit&agrave; di parcheggio, ecc.). Attenzione: <span class="rosso">sono consentiti unicamente caratteri alfanumerici</span> (non sono ammessi caratteri speciali quali il simbolo dell'euro ecc.), mentre i testi tutti in maiuscolo saranno riformattati in minuscolo.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
