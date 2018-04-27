<?php
$url="../"; 
include "../config/mydb.php";

if (isset($_GET['id'])) {
$id=$_GET['id'];
}
else {
header("location: index.php");
}

// carica elenchi
require_once "../config/class_layout.php"; $myobj=new pagina;
require_once "../config/class_infoprezzi.php"; $mysql=new mysql;
$infoprezzi=$mysql->infoprezzi($conn,"");


// data oggi
$oggi= date('d/m/Y - H:i:s');
$msgErr="";
$inviato="";
if (isset($_POST['autore'])){
$descriz=$myobj->mb_convert_encoding($_POST['descriz']);

    // minimo parole in un testo (testo, minimo)
    if ($msgErr=="" && $_POST['feedback']=="") { $msgErr="Devi selezionare una risposta!"; }
    if ($msgErr=="" && $_POST['descriz']=="") { $msgErr="Devi descrivere brevemente la tua Attivit&agrave;: dove si trova, cosa vende, ecc."; }
    if ($msgErr=="" && $_POST['contatti']=="") { $msgErr="Manca un numero di telefono, un indirizzo o un qualsiasi altro contatto per poterti rintracciare!"; }
    if ($msgErr=="" && $_POST['autore']=="") { $msgErr="Manca il tuo nome!"; }

    // invio email // $autore,$email,$telef, $testo,$tipo
    if ($msgErr=="") { 
        $mittente = 'From: "visitatore promogenova.it" '; //<info@promogenova.it>
        $subject="Richiesta informazioni inviata a Promogenova.it";

        $txt=$myobj->mb_convert_encoding($_POST['descriz']);
        $somm="Nome richiedente: ".$txt."\r\n";

        $somm.="Descrizione: ".$descriz."\r\n";

        $txt=$myobj->mb_convert_encoding($_POST['contatti']);
        $somm.="Contatti: ".$txt."\r\n";

        $txt=$myobj->mb_convert_encoding($_POST['feedback']);
        $somm.="Origine interesse: ".$txt."\r\n";

        $ip=$_SERVER['REMOTE_ADDR']; $somm.="IP: ".$ip."\r\n";
        $dataMess=date ("d/m/Y H:i"); $somm.="Data: ".$dataMess."\r\n";

        $somm.="\r\n\r\n";

        $txtConv=$mysql->mb_convert_encoding($infoprezzi['proposta'][$id]);
        $body=$somm."Proposta scelta: ".$txtConv;

        $to="postmaster@promogenova.it";
        mail($to,$subject,$body,$mittente);
        $inviato="ok";
    }

}




// struttura html
$txtConv=$mysql->mb_convert_encoding($infoprezzi['proposta'][$id]);
$title=ucfirst($txtConv);
$metaDescription=$txtConv." - Dettagli sulla proposta contrattuale - Promogenova";
$metaKeywords=strtolower($txtConv).", contratti promogenova, proposte promogenova, prezzi promogenova, servizi promogenova, siti internet, vetrine web";
$metaRobots="ALL";
include "../config/head.php";
include "../config/header-nav.php";


// messaggi
$saltaIntest="";
if (isset($msgErr) && $msgErr!=""){
print "<div class='riga'><div class='colonna-1'>";
print "<p class='testo rosso'><span class='bianco sfRosso'>ATTENZIONE!</span> ".$msgErr."</p>";
print "</div></div>";
$saltaIntest="s";
}
if ($inviato=="ok"){
print "<div class='riga'><div class='colonna-1'>";
print "<p class='testo nero'><span class='bianco sfVerde'>MESSAGGIO SPEDITO!</span> Grazie per averci inviato il messaggio.</p>";
print "</div></div>";
$saltaIntest="s";
}
    
if ($saltaIntest==""){
?>
<div class="riga">
<div class="colonna-1-2">
<h1><?php print $title; ?></h1>
<p>Vuoi saperne di pi&ugrave; sul portale? <a href="<?php print $url; ?>faq/" rel="index" ><img src="../lay/continua.png" alt="->" /> Clicca qui!</a><br /><br /></p>
</div>
<div class="colonna-1-4">
<p><img src="<?php print $url; ?>lay/contratto.jpg" alt="info" class="scala" /></p>
</div>
<div class="colonna-1-4">
<h4 class="rosso">Ti interessa?</h4>
<p id="menu">
<a href="#form">Clicca qui per ordinare subito e/o chiedere maggiori informazioni</a>
</p>
</div>
</div>
<?php	
} // chiude salta intest
?>

<div class="riga">
<div class="colonna-2-3">
<a name="proposta"></a>
<?php
print "<h2 class='bianco sfTondo sfVerde'>".$title."</h2><br />";
print "<p class='testo'>";
if ($infoprezzi['sottotipo'][$id]!="") {
    $txtConv=$myobj->mb_convert_encoding($infoprezzi['sottotipo'][$id]);
    print "<span class='grigio'>".$txtConv."</span><br /><br />";
}

$txtConv=$myobj->mb_convert_encoding($infoprezzi['destinatari'][$id]);
print "<b>A chi si rivolge</b>: <span class='verde'>".$txtConv."</span><br /><br />";

$txtConv=$myobj->mb_convert_encoding($infoprezzi['descrizione'][$id]);
print "<b>In cosa consiste</b>: <span class='nero'>".nl2br($txtConv)."</span><br /><br />";

if ($infoprezzi['durata'][$id]!="") {
    $txtConv=$myobj->mb_convert_encoding($infoprezzi['durata'][$id]);
    print "<b>Quanto dura</b>: <span class='verde'>".$txtConv."</span><br /><br />";
}

if ($infoprezzi['costo'][$id]!="") {
    $txtConv=$myobj->mb_convert_encoding($infoprezzi['costo'][$id]);
    print "<b>Quanto cosa</b>: <span class='rosso'>".$txtConv."</span><br /><br />";
}

if ($infoprezzi['scontoclienti'][$id]!="") {
    $txtConv=$myobj->mb_convert_encoding($infoprezzi['scontoclienti'][$id]);
    print "<b>Sconti e agevolazioni</b>: ".$txtConv."<br /><br />";
}

if ($infoprezzi['esempio'][$id]!="") {
    print "<a href='".$url.$infoprezzi['esempio'][$id]."'><img src='../lay/freccia.gif' alt='[clicca]' /> Vedi un esempio</a><br />";
}


// FORM
if ($inviato==""){
print "<br /><br /><br /><h3 class='rosso'>Ti interessa questa proposta? Compila qui sotto!</h3>";
?>
<a name="form"></a>
<form id="reqInfo" method="post" action="?id=<?php print $id; ?>">
<p><label>Il tuo nome</label><br />
<input style="padding:4px" type="text" size="30" name="autore" value="" class="riqInput" /></p>
<p><label>Breve descrizione della Tua attivit&agrave;</label><br />
<textarea style="padding:4px" name="descriz" rows="3" cols="40" class="riqInput"></textarea></p>
<p><label>Dove sei e come contattarti (telefono, mail, profilo fb, ecc.)</label><br />
<textarea style="padding:4px" name="contatti" rows="3" cols="40" class="riqInput"></textarea></p>
<p><label>Come hai saputo di questa proposta?</label><br />
<select option="1" name="feedback" class="riqInput">
<option value="">=== SELEZIONA UNA RISPOSTA ===</option>
<option value="promogenova">Navigando su questo portale</option>
<option value="google">Google o altri motori ricerca</option>
<option value="social">Facebook o altri social network</option>
<option value="consiglio">Consiglio di amici</option>
<option value="cliente">Sono gi&agrave; cliente di Promogenova</option>
</select>
<p><br /><br /><br /><input type="submit" name="azione" value=" CLICCA QUI PER INVIARE " id="invia" class="bottSubmit" />
</form>

<br /><br />
<p>NOTA - Il presente modulo, che verr&agrave; inviato a <i>Promogenova.it</i> in forma strettamente privata, non prevede trasmissione e/o registrazione di dati da parti terze, avvenendo la comunicazione nel pieno rispetto e ai sensi del D.Lgs. n. 196/2003 <i>Codice in materia di protezione dei dati personali</i>.<br/>
<b>Se tutti i dati che hai inviato sono corretti, Ti contatteremo il prima possibile per fornirTi gratuitamente maggiori informazioni</b> sui nostri servizi, le modalit&agrave; di registrazione e attivazione, l'assistenza, le forme e gli estremi del pagamento. </p>
<br /><br /><br /><br />

<?php
} // chiude if non inviato 
?>
</div>

<div class="colonna-1-3">
<a name="altre"></a>
<?php
print "<h2 class='bianco sfTondo sfGrigio'>Altre proposte</h2>";
print "<p class='testo'>";
for ($i=0;$i<count($infoprezzi['id']);$i++) {
    if ($infoprezzi['id'][$i]!=$id) {
        $txtConv=$myobj->mb_convert_encoding($infoprezzi['proposta'][$i]);
        print "<a href='?id=".$infoprezzi['id'][$i]."'>".$txtConv."</a><br />";
    }	
 }    
print "<br /><br /></p>";
?>
</div>
</div>



<?php
include "../config/footer.php";
?>
