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


// oggi
$oggi=date("Ymd");

// scomponi date
$ggIn=substr($ev_dataInizio,6,2); $mmIn=substr($ev_dataInizio,4,2); $aaIn=substr($ev_dataInizio,0,4);
$ggF=substr($ev_dataFine,6,2); $mmF=substr($ev_dataFine,4,2); $aaF=substr($ev_dataFine,0,4);


// se date non impostate, imposta su oggi
/*
if (!isset($_POST['ev_dataInizio']) && !isset($_POST['ev_dataFine'])) {
if ($ev_dataInizio=="") { $ev_dataInizio=date("Ymd"); $ev_oreInizio=date("H").":00"; }
if ($ev_dataFine=="") { $ev_dataFine=date("Ymd"); $ev_oreFine=date("H").":00"; }
}
*/

// calendario
$calendario=$myobj->calendario($oggi);

// reg su db
$msgErr="";

if (isset($_POST['ev_dataInizio']) | isset($_POST['ev_dataFine'])) {

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
    }
    
    // se giorni>30 segnala errore            
    if($msgErr=="" && $contaGiorni>30){ $msgErr="Non puoi creare eventi che durino pi&ugrave; di 30 giorni"; }    
    
    // data pubblicazione
    if($msgErr==""){
        
        // fissa scadenze (1mese prima, 1 mese dopo)
        $dataIn=$_POST['ev_dataInizio'];   
        $ggIn=substr($dataIn,6,2); $mmIn=substr($dataIn,4,2); $aaIn=substr($dataIn,0,4);
        $dataFine=$_POST['ev_dataFine'];   
        $ggF=substr($dataFine,6,2); $mmF=substr($dataFine,4,2); $aaF=substr($dataFine,0,4);
        $ev_anno=$aaF;

    	$ggAvv=$ggIn; $mmAvv=$mmIn-1; $aaAvv=$aaIn;
	    if ($mmAvv<=0){ $mmAvv=12; $aaAvv=$aaIn-1;}     
	    $i1=""; if ($mmIn!=$mmAvv && $mmAvv<10){ $i1="0"; }
    	$i2=""; if ($ggIn!=$ggAvv && $ggAvv<10){ $i2="0"; }
        $newDataAvv=$aaAvv.$i1.$mmAvv.$i2.$ggAvv;
        if ($newDataAvv<$dataIn){ $newDataAvv=$dataIn; }

    	$ggOsc=$ggF; $mmOsc=$mmF+1; $aaOsc=$aaF;
    	if ($mmOsc>12){ $mmOsc=1; $aaOsc=$aaF+1;}  
    	$i1=""; if ($mmF!=$mmOsc && $mmOsc<10){ $i1="0"; }
        $i2=""; if ($ggF!=$ggOsc && $ggOsc<10){ $i2="0"; }
        $newDataOsc=$aaOsc.$i1.$mmOsc.$ggOsc;
                
         
        $ev_dataAvv=$newDataAvv;
        $ev_dataOsc=$newDataOsc;            
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
     
            $sql="UPDATE eventi_dateore SET  
            anno='".mysqli_real_escape_string($conn,stripslashes($ev_anno))."', 
            dataInizio='".mysqli_real_escape_string($conn,stripslashes($ev_dataInizio))."', 
            oreInizio='".mysqli_real_escape_string($conn,stripslashes($ev_oreInizio))."', 
            dataFine='".mysqli_real_escape_string($conn,stripslashes($ev_dataFine))."', 
            oreFine='".mysqli_real_escape_string($conn,stripslashes($ev_oreFine))."', 
            dataAvv='".mysqli_real_escape_string($conn,stripslashes($ev_dataAvv))."', 
            dataOsc='".mysqli_real_escape_string($conn,stripslashes($ev_dataOsc))."' 
            WHERE id='".$id."'";
            $query=mysqli_query($conn,$sql);
      
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
     }
}

// struttura html
$title="Admin ".$attivita." - Evento ".$id." - Modifica date e orari";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica le date e gli orari dell'evento n.ro <?php print $id; ?></h3><br />
<br />
<?php
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br />";
}
?>
<br />
<form id="nuovo00" method="post" action="?id=<?php print $id;?>">

  <p><label>In che giorno <strong>inizia</strong> l'evento?<label><br />
  <select name="ev_dataInizio" options="1">
    <?php
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
  <select name="ev_oreInizio" options="1">
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

  <p><label>In che giorno <strong>finisce</strong> l'evento?<label><br />
  <select name="ev_dataFine" options="1">
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
  <p><label>A che ore inizia?</label>
  <select name="ev_oreFine" options="1">
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

  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<p><a href="<?php print $redirUrl; ?>">Torna all'Evento</a></p>
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
