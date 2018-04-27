<?php
$url="../../"; $urlAdm="../";   
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// data oggi
$oggi= date('d/m/Y - H:i:s');
$msgErr="";
$testo="";
$inviato="";
if (isset($_POST['testo'])){
$testo=$_POST['testo'];

    // minimo parole in un testo (testo, minimo)
    if ($msgErr=="") { $msgErr=$myobj->minimoParole($testo,5); }
    if ($msgErr=="") { $msgErr=$myobj->massimoParole($testo,50); }

    // invio email
    if ($msgErr=="") { 
    $to="postmaster@promogenova.it";
    $subject="Richiesta assistenza ".$oggi." da: ".$attivita." (id cliente: ".$idAttivita.")";
    $body=$testo;
    mail($to,$subject,$body);
    $inviato="ok";
    }

}


// struttura html
$title="Admin ".$attivita." - Richiesta assistenza a Promogenova";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>


<div class="riga">
<div class="colonna-1-2">
<h1>Richiedi assistenza a Promogenova</h1>
<p class="testo ">

<?php
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($inviato=="") {
$testo=$myobj->mb_convert_encoding($testo);
$totParole=str_word_count($testo);
?>
<form id="messaggio" method="post" action="?">
<p><label>Inserisci qui sotto il testo del tuo messaggio</label><br/>
<textarea name="testo" rows="3" cols="30" required><?php print $testo; ?></textarea></p>
<input type="submit" name="azione" value="INVIA" id="invia" class="bottSubmit" />
<br/><br/><br/><br/>
</p>
</form>
<?php
}
else{
print "<h2 class='verde'>Grazie per averci inviato il tuo messaggio. Ti risponderemo quanto prima possibile.</h2>";
print "<a href='../'>Torna al Men&ugrave; principale</a> oppure <a href='assistenza.php'>Scrivi un nuovo messaggio</a>.<br /><br />";	
}
?>

</p>
<br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Per <b><span class='verde'>richiesta d'assistenza</span></b> s'intende una comunicazione urgente di problemi tecnici, disservizi e malfunzionamenti riscontrati sull'Area clienti e/o sul Portale. Affinch&eacute; sia inoltrato, il messaggio deve essere composto da <span class="rosso">non meno di 5</span> e <span class="rosso">non pi&ugrave; di 50 parole</span>.</p>
<p>Campi obbligatori: testo.</p>
</div>
</div>

<?php
include "../footer.php";
?>
