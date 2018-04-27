<?php
$url="../"; 
include "../config/mydb.php";

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;

// data oggi
$oggi= date('d/m/Y - H:i:s');
$msgErr="";
$inviato="";
if (isset($_POST['testo'])){

    // no codici e siti
    if ($msgErr=="") { $msgErr=$myobj->checkTag($_POST['testo']); }
    if ($msgErr=="") { $msgErr=$myobj->checkTag($_POST['autore']); }
    if ($msgErr=="") { $msgErr=$myobj->checkSito($_POST['testo']); }

$testo=$myobj->convTxt($_POST['testo']);

    // minimo parole in un testo (testo, minimo)
    if ($msgErr=="" && $_POST['tipo']=="") { $msgErr="Devi selezionare il tipo di messaggio che vuoi inviare."; }
    if ($msgErr=="" && $_POST['telef']=="") { $msgErr="Manca un numero telefonico a cui poter rispondere."; }
    if ($msgErr=="" && $_POST['email']=="") { $msgErr="Manca un indirizzo di posta elettronica a cui poter rispondere."; }
    if ($msgErr=="" && $_POST['autore']=="") { $msgErr="Manca il mittente (un nome a cui rivolgere l'eventuale risposta)."; }
    if ($msgErr=="") { $msgErr=$myobj->minimoParole($testo,5); }
    if ($msgErr=="") { $msgErr=$myobj->massimoParole($testo,50); }

    // invio email // $autore,$email,$telef, $testo,$tipo
    if ($msgErr=="") { 
        $mittente = 'From: "visitatore promogenova.it" '; //<info@promogenova.it>
        $tipo=$myobj->convTxt($_POST['tipo']);
        $subject="Messaggio inviato a Promogenova.it - ".$tipo;
        $autore=$myobj->convTxt($_POST['autore']);
        $somm="Mittente: ".$autore."\r\n";
        $somm="Tipo di messaggio: ".$tipo."\r\n";
        $ip=$_SERVER['REMOTE_ADDR']; $somm.="IP: ".$ip."\r\n";
        $somm.="E-mail: ".$_POST['email']."\r\n";
        $somm.="Tel: ".$_POST['telef']."\r\n";
        $dataMess=date ("d/m/Y H:i"); $somm.="Data: ".$dataMess."\r\n";
        $somm.="\r\n\r\n";
        $body=$somm.$testo;
        $to="postmaster@promogenova.it";
        mail($to,$subject,$body,$mittente);
        $inviato="ok";
    }

}

// struttura html
$title="Contattaci";
$metaDescription="Invia un messaggio a Promogenova.it";
$metaKeywords="";
$metaRobots="NONE";

include "../config/head.php";
include "../config/header-nav.php";
?>

  
<div class="riga">
<div class="colonna-1-2">
<h1>Contattaci</h1>
<p class="testo">Modulo di invio messaggi a Promogenova.it</p>
<p>Hai un'attivit&agrave;? <a href="<?php print $url; ?>info-e-prezzi/" rel="index" ><img src="../lay/continua.png" alt="->" /> Scopri le nostre proposte!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="<?php print $url; ?>img/calamaio.jpg" alt="calamaio" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h5 class="verde">Per cortesia, prima di scrivere leggi qui</h5>
<p>
Promogenova <b>non risponde</b> a messaggi rivolti a terzi, ivi compresi clienti, n&eacute; a richieste non inerenti al portale. 
Non sono ammessi nel testo indirizzi di siti e/o codici di alcun genere. 
Tutti i campi sono <b>obbligatori</b>. I messaggi recanti e-mail e/o telefono errati non riceveranno risposta. 
</p>
</div>
</div>

<?php
if (isset($msgErr) && $msgErr!=""){
print "<div class='riga'><div class='colonna-1'>";
print "<p class='testo rosso'><span class='bianco sfRosso'>ATTENZIONE!</span> ".$msgErr."</p>";
print "</div></div>";
}

if ($inviato==""){
?>
<div class="riga">
<form id="messaggio" method="post" action="?">
<div class="colonna-1-3">
<p><label>Il tuo nome</label><br />
<input style="padding:4px" type="text" size="25" name="autore" value="" class="riqInput" /></p>
<p><label>La tua e-mail</label><br />
<input style="padding:4px"  type="text" size="25" name="email" value="" class="riqInput" /></p>
<p><label>Telefono/Cellulare</label><br />
<input style="padding:4px"  type="text" size="25" name="telef" value="" class="riqInput" /></p>
</div>
<div class="colonna-1-3">
<p><label>Il tuo messaggio (da 5 a 50 parole)</label><br />
<textarea style="padding:4px" name="testo" rows="10" cols="30" class="riqInput"></textarea></p>
</div>
<div class="colonna-1-3">
<p><label>Tipo di messaggio?</label><br/>
<select name="tipo" options="1" class="riqInput"> 
<option value="" selected>=== SELEZIONA IL TIPO DI MESSAGGIO ===</option>
<option value="info">Richiesta informazioni</option>
<option value="preventivo">Richiesta preventivo</option>
<option value="consulenza">Richiesta consulenza informatica</option>
<option value="segnalazioni">Segnalazione eventi, gruppi o Attivit&agrave;</option>
<option value="suggerimenti">Suggerimenti per migliorare il Portale</option>
<option value="guasti">Segnalazione problemi e malfunzionamenti</option>
<option value="pubblicita">Comunicazioni pubblicitarie</option>
<option value="altro">Altro</option>
 </select></p>
<p><br /><br /><br /><input type="submit" name="azione" value=" CLICCA QUI PER INVIARE " id="invia" class="bottSubmit" style="width:250px" />
</div>
</form>
</div>
<?php
}
else{
print "<div class='riga'><div class='colonna-1'>";
print "<p class='testo nero'><span class='bianco sfVerde'>MESSAGGIO SPEDITO!</span> Grazie per averci inviato il messaggio.</p>";
print "</div></div>";
}

?>


<div class="riga">
<div class="colonna-2-3">
<h4 class="viola">Privacy</h4>
<p class="testo">
Il presente messaggio, che verr&agrave; destinato esclusivamente al destinatario in forma strettamente privata, non prevede trasmissione e/o registrazione di dati da parti terze, avvenendo la comunicazione nel pieno rispetto e ai sensi del D.Lgs. n. 196/2003 Codice in materia di protezione dei dati personali.
<br/><br/>
</p>
</div>
<div class="colonna-1-3 actr">
<br/><br/><img src="../img/logo.png" alt="logo" /><br/><br/><br/>
Promogenova &egrave; presente anche<br/>sui maggiori <a href='../index.php#social'>social network</a>.<br/><br/><br/>
</div>
</div>


<?php
include "../config/footer.php";
?>
