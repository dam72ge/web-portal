<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// js onChange
echo "<script type=\"text/javascript\" language=\"JavaScript\">\n";
echo "function inizioData(ev_dataInizio){location.href='?ev_dataInizio='+ev_dataInizio; }";
echo "function inizioOre(ev_oreInizio){location.href='?ev_oreInizio='+ev_oreInizio;}";
echo "function fineData(ev_dataFine){location.href='?ev_dataFine='+ev_dataFine;}";
echo "function fineOre(ev_oreFine){location.href='?ev_oreFine='+ev_oreFine;}";
echo "</script>"; 

// cambio date GET
if (isset($_GET['ev_dataInizio'])){ $ev_dataInizio=$_GET['ev_dataInizio']; $_SESSION['ev_dataInizio']=$ev_dataInizio; } 
if (isset($_GET['ev_oreInizio'])){ $ev_oreInizio=$_GET['ev_oreInizio']; $_SESSION['ev_oreInizio']=$ev_oreInizio; } 
if (isset($_GET['ev_dataFine'])){ $ev_dataFine=$_GET['ev_dataFine']; $_SESSION['ev_dataFine']=$ev_dataFine; } 
if (isset($_GET['ev_oreFine'])){ $ev_oreFine=$_GET['ev_oreFine']; $_SESSION['ev_oreFine']=$ev_oreFine; } 

// oggi
$oggi=date("Ymd");

// se date non impostate, imposta su oggi
if ($ev_dataInizio=="") { $ev_dataInizio=date("Ymd"); $ev_oreInizio=date("H").":00"; }
if ($ev_dataFine=="") { $ev_dataFine=date("Ymd"); $ev_oreFine=date("H").":00"; }

// scomponi date
$ggIn=substr($ev_dataInizio,6,2); $mmIn=substr($ev_dataInizio,4,2); $aaIn=substr($ev_dataInizio,0,4);
$ggF=substr($ev_dataFine,6,2); $mmF=substr($ev_dataFine,4,2); $aaF=substr($ev_dataFine,0,4);

// fissa scadenze (1mese prima, 1 mese dopo)
$ev_anno=$aaF;

$ggAvv=$ggIn; $mmAvv=$mmIn-1; $aaAvv=$aaIn;
if ($mmAvv<=0){ $mmAvv=12; $aaAvv=$aaIn-1;}     
$i1=""; if ($mmIn!=$mmAvv && $mmAvv<10){ $i1="0"; }
$i2=""; if ($ggIn!=$ggAvv && $ggAvv<10){ $i2="0"; }
$ev_dataAvv=$aaAvv.$i1.$mmAvv.$i2.$ggAvv;
if ($ev_dataAvv<$ev_dataInizio){ $ev_dataAvv=$ev_dataInizio; }
$ev_anno=$aaF;

$ggOsc=$ggF; $mmOsc=$mmF+1; $aaOsc=$aaF;
if ($mmOsc>12){ $mmOsc=1; $aaOsc=$aaF+1;}  
$i1=""; if ($mmF!=$mmOsc && $mmOsc<10){ $i1="0"; }
$i2=""; if ($ggF!=$ggOsc && $ggOsc<10){ $i2="0"; }
$ev_dataOsc=$aaOsc.$i1.$mmOsc.$ggOsc;

if ($ev_dataAvv!=""){ 
    $_SESSION['ev_anno']=$aaF; 
    $_SESSION['ev_dataAvv']=$ev_dataAvv; 
    $_SESSION['ev_dataOsc']=$ev_dataAvv; 
} 


// reg su db
$msgErr="";

// calendario
$calendario=$myobj->calendario($oggi);

// reg su db
$msgErr="";


if (isset($_POST['ev_dataInizio']) && isset($_POST['ev_dataFine'])) {

    // controlli
    if($_POST['ev_dataInizio']>$_POST['ev_dataFine']){ $msgErr="La data di fine evento non pu&ograve; precedere quella di inizio!"; }
    
    // periodo giorni
    $inizioNUM=0; $fineNUM=0; $contaGiorni=0;
    if($msgErr==""){
        for ($i=0;$i<count($calendario['giorno']);$i++) {
        $dataNum=$myobj->visDataNum($calendario['anno'][$i],$calendario['mm'][$i],$calendario['giorno'][$i]);
        if ($_POST['ev_dataInizio']==$dataNum){ $inizioNUM=$i; }
        if ($_POST['ev_dataFine']==$dataNum){ $fineNUM=$i; }    
        }
    $contaGiorni=$fineNUM-$inizioNUM;
    // se giorni>30 segnala errore            
    if($contaGiorni>30){ $msgErr="Non puoi creare eventi che durino pi&ugrave; di 30 giorni"; }    
    }
        
    // data pubblicazione
    if($msgErr==""){
        
        // fissa scadenze (1mese prima, 1 mese dopo)
        $ev_dataInizio=$_POST['ev_dataInizio'];
        $ev_oreInizio=$_POST['ev_oreInizio'];
        $ev_dataFine=$_POST['ev_dataFine'];
        $ev_oreFine=$_POST['ev_oreFine'];

        // SALVATAGGIO IN SESSIONE
        $_SESSION['ev_anno']=$ev_anno; 
        $_SESSION['ev_dataInizio']=$ev_dataInizio;
        $_SESSION['ev_oreInizio']=$ev_oreInizio;  
        $_SESSION['ev_dataFine']=$ev_dataFine; 
        $_SESSION['ev_oreFine']=$ev_oreFine; 
        $_SESSION['ev_dataAvv']=$ev_dataAvv;
        $_SESSION['ev_dataOsc']=$ev_dataOsc;
           
        /*
        print $_SESSION['ev_dataInizio'].", ".$ev_dataInizio."<br />";
        print $_SESSION['ev_dataFine'].",".$ev_dataFine; 
        exit;
        */

        echo "<script language=\"JavaScript\">\n";
        echo "location.href='nuovo-luogo.php';\n"; 
        echo "</script>"; 
     }
}

// struttura html
$title="Admin ".$attivita." - Nuovo evento - Step 2 di 6: Date";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Evento - Passaggio 2 di 6: Date</h4>
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
print "<br /><br /><span class='rosso'>".$msgErr."</span><br />";
}
?>
<br />
<form id="nuovoevDate" name="nuovoevDate" method="post" action="?">

  <p><label>In che giorno <strong>inizia</strong> l'evento?</label><br />
  <select name="ev_dataInizio" id="ev_dataInizio" options="1" onchange="inizioData(this.value)" >
    <?php
    //print "<select name='ev_dataInizio' options='1' onChange='inizioData(this.value)'>";
    for ($i=0;$i<count($calendario['giorno']);$i++) {
    $dataNum=$myobj->visDataNum($calendario['anno'][$i],$calendario['mm'][$i],$calendario['giorno'][$i]);
    if ($dataNum>=$oggi) {
    print "<option value='".$dataNum."'"; 
    if ($calendario['giorno'][$i]==$ggIn && $calendario['mm'][$i]==$mmIn && $calendario['anno'][$i]==$aaIn) { print " selected"; } 
    print ">".$calendario['giorno'][$i]." ".$calendario['mese'][$i]." ".$calendario['anno'][$i]."</option>";
    }
	}
    ?>
  </select>
  </p>
  <p><label>A che ORE inizia?</label>
  <select name="ev_oreInizio" id="ev_oreInizio"  options="1" onchange="inizioOre(this.value)">
  <?php
    for ($i=0;$i<24;$i++) {

        $i1=""; if ($i<10) { $i1="0"; } $selOre=$i1.$i.":00";
        print "<option value='".$i1.$i.":00'";
        if ($ev_oreInizio==$selOre) { print " selected"; }
        print ">".$i1.$i.":00</option>"; 

        $selOre=$i1.$i.":15";
        print "<option value='".$i1.$i.":15'";
        if ($ev_oreInizio==$selOre) { print " selected"; }
        print ">".$i1.$i.":15</option>";

        $selOre=$i1.$i.":30";
        print "<option value='".$i1.$i.":30'";
        if ($ev_oreInizio==$selOre) { print " selected"; }
        print ">".$i1.$i.":30</option>";

        $selOre=$i1.$i.":45";
        print "<option value='".$i1.$i.":45'";
        if ($ev_oreInizio==$selOre) { print " selected"; }
        print ">".$i1.$i.":45</option>";
    }
  ?>
  </select>
  </p>
  <br />

  <p><label>In che giorno <strong>finisce</strong> l'evento?</label><br />
  <select name="ev_dataFine" options="1" onchange="fineData(this.value)">
    <?php
    for ($i=0;$i<count($calendario['giorno']);$i++) {
    $dataNum=$myobj->visDataNum($calendario['anno'][$i],$calendario['mm'][$i],$calendario['giorno'][$i]);
    if ($dataNum>=$oggi) {
    print "<option value='".$dataNum."'"; 
    if ($calendario['giorno'][$i]==$ggF && $calendario['mm'][$i]==$mmF && $calendario['anno'][$i]==$aaF) { print " selected"; } 
    print ">".$calendario['giorno'][$i]." ".$calendario['mese'][$i]." ".$calendario['anno'][$i]."</option>";
    }
	}
    ?>
  </select>
  </p>
  <p><label>A che ore finisce?</label>
  <select name="ev_oreFine" options="1" onchange="fineOre(this.value)">
  <?php
    for ($i=0;$i<24;$i++) {

        $i1=""; if ($i<10) { $i1="0"; } $selOre=$i1.$i.":00";
        print "<option value='".$i1.$i.":00'";
        if ($ev_oreFine==$selOre) { print " selected"; }
        print ">".$i1.$i.":00</option>"; 

        $selOre=$i1.$i.":15";
        print "<option value='".$i1.$i.":15'";
        if ($ev_oreFine==$selOre) { print " selected"; }
        print ">".$i1.$i.":15</option>";

        $selOre=$i1.$i.":30";
        print "<option value='".$i1.$i.":30'";
        if ($ev_oreFine==$selOre) { print " selected"; }
        print ">".$i1.$i.":30</option>";

        $selOre=$i1.$i.":45";
        print "<option value='".$i1.$i.":45'";
        if ($ev_oreFine==$selOre) { print " selected"; }
        print ">".$i1.$i.":45</option>";
    }

        print "<option value='24:00'";
        if ($ev_oreFine=="24:00") { print " selected"; }
        print ">24:00</option>";
  ?>
  </select>
  </p>
  <br />
  <br />

  <input type="hidden" name="cambia" value="s" />

  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<p>Torna al <a href="index.php">Menu eventi</a> | Torna all'<a href="../">Inizio</a></p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Scegli il <strong>periodo</strong> in cui si svolger&agrave; l'evento, facendo attenzione che esso non superi il <strong>limite consentito di durata</strong> (un mese). <br />Qualora la data scelta di inizio evento sia oggi, l'evento apparir&agrave; immediatamente sul portale, altrimenti verr&agrave; pubblicato con largo anticipo (<span class="verde">1 mese prima</span>) e lasciato sul portale ancora per <span class="verde">1 mese dopo la fine</span> dell'evento.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
