<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// js onChange
echo "<script type=\"text/javascript\" language=\"JavaScript\">\n";
echo "function elencoProvince(ev_idR){location.href='?ev_idR='+ev_idR;}";
echo "function elencoComuni(ev_idP){location.href='?ev_idP='+ev_idP;}";
echo "function elencoMunicipi(ev_idC){location.href='?ev_idC='+ev_idC;}";
echo "function elencoQuartieri(ev_idM){location.href='?ev_idM='+ev_idM;}";
echo "</script>"; 


if (isset($_GET['rip'])) {
	$ev_idR=$idR;
	$ev_idP=$idP;
	$ev_idC=$idC;
	$ev_idM=$idM;
	$ev_idQ=$idQ;
	$ev_luogo="";
}


// idQ
if (isset($_GET['ev_idQ'])){ 
    $ev_idQ=$_GET['ev_idQ']; 
    $sql="SELECT idM,idC,idP,idR FROM quartieri WHERE idQ='".$ev_idQ."' ";
    $query=mysqli_query($conn,$sql); $riga=mysql_fetch_array($query);
    $ev_idM=$riga['idM'];
    $ev_idC=$riga['idC'];
    $ev_idP=$riga['idP'];
    $ev_idR=$riga['idR'];
    } 
    
// idM
if (isset($_GET['ev_idM'])){ 
    $ev_idQ=0;
    $ev_idM=$_GET['ev_idM']; 
    $sql="SELECT idC,idP,idR FROM municipi WHERE idM='".$ev_idM."' ";
    $query=mysqli_query($conn,$sql); $riga=mysql_fetch_array($query);
    $ev_idC=$riga['idC'];
    $ev_idP=$riga['idP'];
    $ev_idR=$riga['idR'];
    } 

// idC
if (isset($_GET['ev_idC'])){ 
    $ev_idQ=0;
    $ev_idM=0;
    $ev_idC=$_GET['ev_idC']; 
    $sql="SELECT idP,idR FROM comuni WHERE idC='".$ev_idC."' ";
    $query=mysqli_query($conn,$sql); $riga=mysql_fetch_array($query);
    $ev_idP=$riga['idP'];
    $ev_idR=$riga['idR'];
    } 

// idP
if (isset($_GET['ev_idP'])){ 
    $ev_idQ=0;
    $ev_idM=0;
    $ev_idC=0;
    $ev_idP=$_GET['ev_idP']; 
    $sql="SELECT idR FROM province WHERE idP='".$ev_idP."' ";
    $query=mysqli_query($conn,$sql); $riga=mysql_fetch_array($query);
    $ev_idR=$riga['idR'];
    } 

// idR
if (isset($_GET['ev_idR'])){ 
    $ev_idQ=0;
    $ev_idM=0;
    $ev_idC=0;
    $ev_idP=0;
    $ev_idR=$_GET['ev_idR']; 
    } 


// salva modifiche
$salva="n";

// cambia quartiere
if (isset($_POST['ev_idQ']) && $_POST['ev_idQ']>=0) {
    $ev_idQ=$_POST['ev_idQ'];
    $salva="s";
}
// cambia municipio
if (isset($_POST['ev_idM']) && $_POST['ev_idM']>=0) {
    $ev_idM=$_POST['ev_idM'];
    $salva="s";
}
// cambia comune
if (isset($_POST['ev_idC']) && $_POST['ev_idC']>=0) {
    $ev_idC=$_POST['ev_idC'];
    $salva="s";
}
// cambia provincia
if (isset($_POST['ev_idP']) && $_POST['ev_idP']>=0) {
    $ev_idP=$_POST['ev_idP'];
    $salva="s";
}
// cambia regione
if (isset($_POST['ev_idR']) && $_POST['ev_idR']>=0) {
    $ev_idR=$_POST['ev_idR'];
    $salva="s";
}


// carica elenchi
$regioni=$myobj->regioni("","ORDER BY regione ASC");
$where="AND province.idR='".$ev_idR."'";
$province=$myobj->province($where,"ORDER BY regione ASC");
$where="AND comuni.idP='".$ev_idP."'";
$comuni=$myobj->comuni($where,"ORDER BY provincia ASC");
$where="AND municipi.idC='".$ev_idC."'";
$municipi=$myobj->municipi($where,"ORDER BY comune ASC");
$where="AND municipi.idM='".$ev_idM."'";
$quartieri=$myobj->quartieri($where,"ORDER BY municipio ASC");


// reg su db
if ($salva=="s") {
    

    // ricarica elenchi
    $regioni=$myobj->regioni("","ORDER BY idR ASC");
    $province=$myobj->province("","ORDER BY idP ASC");
    $comuni=$myobj->comuni("","ORDER BY idC ASC");
    $municipi=$myobj->municipi("","ORDER BY idM ASC");
    $quartieri=$myobj->quartieri("","ORDER BY idQ ASC");

    // SALVATAGGIO IN SESSIONE
    
    $ev_luogo="";
    if($ev_idR>0){$ev_luogo.=" Regione ".$regioni['regione'][$_POST['ev_idR']];} else{$ev_luogo.="Tutta Italia ";}
    if($ev_idP>0){$ev_luogo.=" Provincia di ".ucwords($province['provincia'][$ev_idP]);} else{$ev_luogo.="Tutte le Province ";}
    if($ev_idC>0){$ev_luogo.=" Comune di ".ucwords($comuni['comune'][$ev_idC]);} else{$ev_luogo.="Tutti i Comuni ";}
    if($ev_idM>0){$ev_luogo.=" Municipio ".$municipi['municipio'][$ev_idM];} else{$ev_luogo.="Tutti i Municipi ";}
    if($ev_idQ>0){$ev_luogo.=" ".$quartieri['quartiere'][$ev_idQ];} else{$ev_luogo.=" ";}
    
      $_SESSION['ev_luogo']=$ev_luogo; 
      $_SESSION['ev_idR']=$ev_idR; 
      $_SESSION['ev_idP']=$ev_idP; 
      $_SESSION['ev_idC']=$ev_idC; 
      $_SESSION['ev_idM']=$ev_idM; 
      $_SESSION['ev_idQ']=$ev_idQ; 
      
      // passa automaticamente al prossimo step
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-testo.php';\n"; 
  echo "</script>"; 

      //header("location: nuovo-testo.php");
}

// struttura html
$title="Admin ".$attivita." - Nuovo evento - Step 3 di 6: Luogo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Evento - Passaggio 3 di 6: Luogo</h4>
<?php
if ($_SESSION['ev_titolo']!="" && $_SESSION['ev_testo']!=""){ 
?>
<a href="nuovo.php">1 Titolo</a> | 
<a href="nuovo-date.php">2 Date</a> | 
<a href="nuovo-luogo.php">3 Luogo</a> | 
<a href="nuovo-testo.php">4 Testo</a> | 
<a href="nuovo-immagine.php">5 Immagine</a> | 
<a href="nuovo-pubblica.php">6 Anteprima e Pubblicazione</a>
<?php
}
?>
<br />

<form id="nuovoevLuogo" method="post" action="?">
<br /><br />
<?php
/*
if (isset($_POST['ev_idR'])) {
print $_POST['ev_idR'].", ".$ev_idR."<br />";
print $_POST['ev_idP'].", ".$ev_idP."<br />";
print $_POST['ev_idC'].", ".$ev_idC."<br />";
print $_POST['ev_idM'].", ".$ev_idM."<br />";
print $_POST['ev_idQ'].", ".$ev_idQ."<br />";
}
*/

print "<p><label>Regione</label><br />";
print "<select options='1' name='ev_idR'  onchange='elencoProvince(this.value)'>";
print "<option value='0'"; 
if ($ev_idR==0) { print " selected";}
print ">TUTTA ITALIA + ESTERO</option>";
for ($i=1;$i<count($regioni['idR']);$i++) {
print "<option value='".$regioni['idR'][$i]."'";
if ($regioni['idR'][$i]==$ev_idR) { print " selected";}
$nome=$myobj->mb_convert_encoding($regioni['regione'][$i]);
print ">".ucwords($nome)."</option>";
}
print "</select></p>";

    // provincia
if ($ev_idR>0){
    print "<p><label>Provincia</label><br />";
    print "<select options='1' name='ev_idP'  onchange='elencoComuni(this.value)'>";
    print "<option value='0'";  
    if ($ev_idP==0) { print " selected";}
    print ">TUTTE LE PROVINCE</option>";
    for ($i=1;$i<count($province['idP']);$i++) {
    print "<option value='".$province['idP'][$i]."'";
    if ($province['idP'][$i]==$ev_idP) { print " selected";}
    $nome=$myobj->mb_convert_encoding($province['provincia'][$i]);
    print ">".ucwords($nome)."</option>";
    }
    print "</select></p>";
    }
else { print "<input type='hidden' name='ev_idP' value='0'>"; }


    // comune
if ($ev_idR>0 && $ev_idP>0){
    print "<p><label>Comune</label><br />";
    print "<select options='1' name='ev_idC'  onchange='elencoMunicipi(this.value)'>";
    print "<option value='0'";  
    if ($ev_idC==0) { print " selected";}
    print ">TUTTI I COMUNI</option>";
    for ($i=1;$i<count($comuni['idC']);$i++) {
    print "<option value='".$comuni['idC'][$i]."'";
    if ($comuni['idC'][$i]==$ev_idC) { print " selected";}
    $nome=$myobj->mb_convert_encoding($comuni['comune'][$i]);
    print ">".ucwords($nome)."</option>";
    }
    print "</select></p>";
}
else { print "<input type='hidden' name='ev_idC' value='0'>"; }

    // municipio
if ($ev_idR>0 && $ev_idP>0 && $ev_idC>0){
    print "<p><label>Municipio</label><br />";
    print "<select options='1' name='ev_idM'  onchange='elencoQuartieri(this.value)'>";
    print "<option value='0'";  
    if ($ev_idC==0) { print " selected";}
    print ">TUTTI I MUNICIPI</option>";
    for ($i=1;$i<count($municipi['idM']);$i++) {
    print "<option value='".$municipi['idM'][$i]."'";
    if ($municipi['idM'][$i]==$ev_idM) { print " selected";}
    $nome=$myobj->mb_convert_encoding($municipi['municipio'][$i]);
    print ">".ucwords($nome)."</option>";
    }
    print "</select></p>";
}
else { print "<input type='hidden' name='ev_idM' value='0'>"; }

    // quartiere
if ($ev_idR>0 && $ev_idP>0 && $ev_idC>0 && $ev_idM>0){
    print "<p><label>Quartiere</label><br />";
    print "<select options='1' name='ev_idQ'>";
    print "<option value='0'";  
    if ($ev_idC==0) { print " selected";}
    print ">TUTTI I QUARTIERI</option>";
    for ($i=1;$i<count($quartieri['idQ']);$i++) {
    print "<option value='".$quartieri['idQ'][$i]."'";
    if ($quartieri['idQ'][$i]==$ev_idQ) { print " selected";}
    $nome=$myobj->mb_convert_encoding($quartieri['quartiere'][$i]);
    print ">".ucwords($nome)."</option>";
    }
    print "</select></p>";
}
else { print "<input type='hidden' name='ev_idQ' value='0'>"; }
?>    

<p><br /><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<a href="?rip=s">Clicca qui</a> se vuoi ripristinare le zone iniziali.<br/>
<p>Torna al <a href="index.php">Menu eventi</a> | Torna all'<a href="../">Inizio</a></p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Compila questo campo solo se desideri <span class="verde"><strong>promuovere</strong></span> questo evento in una zona diversa da quella in cui opera la tua Attivit&agrave;. Per procedere senza errori, ricorda che devi <span class="verde">selezionare di volta in volta</span> le <strong>singole zone</strong> richieste (Regioni, Province, ecc.).<br />
<span class="rosso"><strong>ATTENZIONE</strong>: una volta impostato un luogo, questo non sar&agrave; pi&ugrave; modificabile</span> 
</p>
<p>Campi obbligatori: tutti.</p>
<br /><br /><br /><br /><br />
</div>
</div>

<?php
include "../footer.php";
?>
