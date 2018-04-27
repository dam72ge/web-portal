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
        $sqldopp="SELECT titolo FROM eventi WHERE titolo LIKE '".mysqli_real_escape_string($conn,stripslashes($new_titolo))."'";
        $querydopp=mysql_query($sqldopp);
        $dopp=mysql_fetch_array($querydopp);
    if (isset($dopp['titolo']) && $dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un evento con questo titolo!"; }
    }
    if ($msgErr==""){
        $sqldopp="SELECT titolo FROM eventi WHERE titolo LIKE '".mysqli_real_escape_string($conn,stripslashes($_POST['ev_titolo']))."'";
        $querydopp=mysql_query($sqldopp);
        $dopp=mysql_fetch_array($querydopp);
    if (isset($dopp['titolo']) && $dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un evento con questo titolo!"; }
    }

// SALVATAGGIO IN SESSIONE
    if ($msgErr==""){

      $ev_titolo=$myobj->convTitle($_POST['ev_titolo']); // formatta testo
      //$ev_titolo=$myobj->formatta($_POST['ev_titolo']); // formatta testo
      $_SESSION['ev_titolo']=$ev_titolo; $_POST['ev_titolo']=$ev_titolo;
      $_POST['upd']="n";      
      
            $sql="UPDATE eventi SET  
            titolo='".mysqli_real_escape_string($conn,stripslashes($ev_titolo))."' 
            WHERE id='".$id."'";
            $query=mysqli_query($conn,$sql);
      
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
    }
}

// struttura html
$title="Admin ".$attivita." - Evento ".$id." - Modifica titolo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica il titolo dell'evento n.ro <?php print $id; ?></h3><br />
<br />
<?php
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}
?>
<form id="nuovo00" method="post" action="?id=<?php print $id; ?>">

  <p><label for="titoloEv">Titolo dell'Evento<label><br />
  <textarea name="ev_titolo" id="titoloEv" rows="5" cols="30" autofocus required><?php print $ev_titolo; ?></textarea></p>

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<p><a href="<?php print $redirUrl; ?>">Torna all'Evento</a></p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Inserisci un <b>Titolo</b> che sia composto di da <span class="rosso">almeno 1 parola</span> di 3 caratteri e/o una frase di non pi&ugrave; di <span class="rosso">120 caratteri complessivi</span>. Attenzione: sono consentiti unicamente caratteri alfanumerici (non sono ammessi caratteri speciali quali il simbolo dell'euro ecc.), mentre i testi in maiuscolo saranno riformattati tutti in minuscolo.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
