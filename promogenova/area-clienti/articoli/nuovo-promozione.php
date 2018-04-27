<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// js onChange
echo "<script type=\"text/javascript\" language=\"JavaScript\">\n";
echo "function elencoProvince(art_idR){location.href='?art_idR='+art_idR;}";
echo "function elencoComuni(art_idP){location.href='?art_idP='+art_idP;}";
echo "function elencoMunicipi(art_idC){location.href='?art_idC='+art_idC;}";
echo "function elencoQuartieri(art_idM){location.href='?art_idM='+art_idM;}";
echo "</script>"; 

/*
	$art_idR=0;
	$art_idP=0;
	$art_idC=0;
	$art_idM=0;
	$art_idQ=0;
*/

// adegua a zona cliente
if (isset($_GET['rip'])) {
	$art_idR=$idR;
	$art_idP=$idP;
	$art_idC=$idC;
	$art_idM=$idM;
	$art_idQ=$idQ;
}

// idQ
if (isset($_GET['art_idQ'])){ 
    $art_idQ=$_GET['art_idQ']; 
    $sql="SELECT idM,idC,idP,idR FROM quartieri WHERE idQ='".$art_idQ."' ";
    $query=mysqli_query($conn,$sql); $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $art_idM=$riga['idM'];
    $art_idC=$riga['idC'];
    $art_idP=$riga['idP'];
    $art_idR=$riga['idR'];
    } 
    
// idM
if (isset($_GET['art_idM'])){ 
    $art_idM=$_GET['art_idM']; 
    $sql="SELECT idC,idP,idR FROM municipi WHERE idM='".$art_idM."' ";
    $query=mysqli_query($conn,$sql); $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $art_idC=$riga['idC'];
    $art_idP=$riga['idP'];
    $art_idR=$riga['idR'];
    } 

// idC
if (isset($_GET['art_idC'])){ 
    $art_idC=$_GET['art_idC']; 
    $sql="SELECT idP,idR FROM comuni WHERE idC='".$art_idC."' ";
    $query=mysqli_query($conn,$sql); $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $art_idP=$riga['idP'];
    $art_idR=$riga['idR'];
    } 

// idP
if (isset($_GET['art_idP'])){ 
    $art_idP=$_GET['art_idP']; 
    $sql="SELECT idR FROM province WHERE idP='".$art_idP."' ";
    $query=mysqli_query($conn,$sql); $riga=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $art_idR=$riga['idR'];
    } 

// idR
if (isset($_GET['art_idR'])){ 
    $art_idR=$_GET['art_idR']; 
    } 


// salva modifiche
$salva="n";

// cambia quartiere
if (isset($_POST['art_idM']) && $_POST['art_idQ']!=$art_idQ) {
    $art_idQ=$_POST['art_idQ'];
    $salva="s";
}
// cambia municipio
if (isset($_POST['art_idM']) && $_POST['art_idM']!=$art_idM) {
    $art_idM=$_POST['art_idM'];
    $salva="s";
}
// cambia comune
if (isset($_POST['art_idC']) && $_POST['art_idC']!=$art_idC) {
    $art_idC=$_POST['art_idC'];
    $salva="s";
}
// cambia provincia
if (isset($_POST['art_idP']) && $_POST['art_idP']!=$art_idP) {
    $art_idP=$_POST['art_idP'];
    $salva="s";
}
// cambia regione
if (isset($_POST['art_idR']) && $_POST['art_idR']!=$art_idR) {
    $art_idR=$_POST['art_idR'];
    $salva="s";
}

// reg su db
if ($salva=="s") {
    
    // SALVATAGGIO IN SESSIONE
/*
print $_POST['art_idR'].", ".$art_idR."<br />";
print $_POST['art_idP'].", ".$art_idP."<br />";
print $_POST['art_idC'].", ".$art_idC."<br />";
print $_POST['art_idM'].", ".$art_idM."<br />";
print $_POST['art_idQ'].", ".$art_idQ."<br />";
exit;
*/
      $art_promozione="s";
      $_SESSION['art_promozione']="s"; 
      $_SESSION['art_idR']=$art_idR; 
      $_SESSION['art_idP']=$art_idP; 
      $_SESSION['art_idC']=$art_idC; 
      $_SESSION['art_idM']=$art_idM;
      $_SESSION['art_idQ']=$art_idQ; 
      
      // passa automaticamente al prossimo step
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-pubblica.php';\n"; 
  echo "</script>"; 
      //header("location: nuovo-pubblica.php");
}

// carica elenchi
$regioni=$myobj->regioni($conn,"","ORDER BY regione ASC");
$where="AND province.idR='".$art_idR."'";
$province=$myobj->province($conn,$where,"ORDER BY regione ASC");
$where="AND comuni.idP='".$art_idP."'";
$comuni=$myobj->comuni($conn,$where,"ORDER BY provincia ASC");
$where="AND municipi.idC='".$art_idC."'";
$municipi=$myobj->municipi($conn,$where,"ORDER BY comune ASC");
$where="AND municipi.idM='".$art_idM."'";
$quartieri=$myobj->quartieri($conn,$where,"ORDER BY municipio ASC");

// struttura html
$title="Admin ".$attivita." - Nuovo articolo - Step 5 di 6: Luogo (Promozioni fuori zona)";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Articolo - Passaggio 5 di 6: Luogo</h4>
<?php
if ($_SESSION['art_titolo']!="" && $_SESSION['art_testo']!="" && $_SESSION['art_idMacro']>0){ 
?>
<a href="nuovo.php">1 Titolo</a> | 
<a href="nuovo-testo.php">2 Testo</a> | 
<a href="nuovo-immagine.php">3 Immagine</a> | 
<a href="nuovo-categoria.php">4 Categoria comm.le</a> | 
<a href="nuovo-promozione.php">5 Luogo (promozioni)</a> | 
<a href="nuovo-pubblica.php">6 Anteprima e Pubblicazione</a>
<br />
<?php    
}

// OPZIONE PROMOZIONI ATTIVE
if ($creaPromo=="s") {
?>

<form id="nuovo00" method="post" action="?">
<br /><br />
<!--
<p class="riquadro"><label class="rosso"><strong>Vuoi cambiare zona</strong>?</label><br />
<select name="conferma" options="1">
<option value="n" selected>No, vai avanti</option>
<option value="s">S&igrave;</option>
</select>
</p>
-->
<?php
/*
if (isset($_POST['art_idR'])) {
print $_POST['art_idR'].", ".$art_idR."<br />";
print $_POST['art_idP'].", ".$art_idP."<br />";
print $_POST['art_idC'].", ".$art_idC."<br />";
print $_POST['art_idM'].", ".$art_idM."<br />";
print $_POST['art_idQ'].", ".$art_idQ."<br />";
}
*/

print "<p><label>Regione</label><br />";
print "<select options='1' name='art_idR' onchange='elencoProvince(this.value)'>";
print "<option value='0'"; 
if ($art_idR==0) { print " selected";}
print ">TUTTA ITALIA + ESTERO</option>";
for ($i=1;$i<count($regioni['idR']);$i++) {
print "<option value='".$regioni['idR'][$i]."'";
if ($regioni['idR'][$i]==$art_idR) { print " selected";}
$nome=$myobj->mb_convert_encoding($regioni['regione'][$i]);
print ">".ucwords($nome)."</option>";
}
print "</select></p>";

    // provincia
if ($art_idR>0){
    print "<p><label>Provincia</label><br />";
    print "<select options='1' name='art_idP' onchange='elencoComuni(this.value)'>";
    print "<option value='0'";  
    if ($art_idP==0) { print " selected";}
    print ">TUTTE LE PROVINCE</option>";
    for ($i=1;$i<count($province['idP']);$i++) {
    print "<option value='".$province['idP'][$i]."'";
    if ($province['idP'][$i]==$art_idP) { print " selected";}
    $nome=$myobj->mb_convert_encoding($province['provincia'][$i]);
    print ">".ucwords($nome)."</option>";
    }
    print "</select></p>";
    }
else { print "<input type='hidden' name='art_idP' value='0'>"; }


    // comune
if ($art_idR>0 && $art_idP>0){
    print "<p><label>Comune</label><br />";
    print "<select options='1' name='art_idC' onchange='elencoMunicipi(this.value)'>";
    print "<option value='0'";  
    if ($art_idC==0) { print " selected";}
    print ">TUTTI I COMUNI</option>";
    for ($i=1;$i<count($comuni['idC']);$i++) {
    print "<option value='".$comuni['idC'][$i]."'";
    if ($comuni['idC'][$i]==$art_idC) { print " selected";}
    $nome=$myobj->mb_convert_encoding($comuni['comune'][$i]);
    print ">".ucwords($nome)."</option>";
    }
    print "</select></p>";
}
else { print "<input type='hidden' name='art_idC' value='0'>"; }

    // municipio
if ($art_idR>0 && $art_idP>0 && $art_idC>0){
    print "<p><label>Municipio</label><br />";
    print "<select options='1' name='art_idM' onchange='elencoQuartieri(this.value)'>";
    print "<option value='0'";  
    if ($art_idC==0) { print " selected";}
    print ">TUTTI I MUNICIPI</option>";
    for ($i=1;$i<count($municipi['idM']);$i++) {
    print "<option value='".$municipi['idM'][$i]."'";
    if ($municipi['idM'][$i]==$art_idM) { print " selected";}
    $nome=$myobj->mb_convert_encoding($municipi['municipio'][$i]);
    print ">".ucwords($nome)."</option>";
    }
    print "</select></p>";
}
else { print "<input type='hidden' name='art_idM' value='0'>"; }

    // quartiere
if ($art_idR>0 && $art_idP>0 && $art_idC>0 && $art_idM>0){
    print "<p><label>Quartiere</label><br />";
    print "<select options='1' name='art_idQ'>";
    print "<option value='0'";  
    if ($art_idC==0) { print " selected";}
    print ">TUTTI I QUARTIERI</option>";
    for ($i=1;$i<count($quartieri['idQ']);$i++) {
    print "<option value='".$quartieri['idQ'][$i]."'";
    if ($quartieri['idQ'][$i]==$art_idQ) { print " selected";}
    $nome=$myobj->mb_convert_encoding($quartieri['quartiere'][$i]);
    print ">".ucwords($nome)."</option>";
    }
    print "</select></p>";
}
else { print "<input type='hidden' name='art_idQ' value='0'>"; }
?>    

<p><br /><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<br />
<a href="?rip=s">Clicca qui</a> se vuoi ripristinare le zone iniziali.
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Compila questo campo solo se desideri <span class="verde"><strong>promuovere</strong></span> questo articolo in una zona diversa da quella in cui opera la tua Attivit&agrave;. Per procedere senza errori, ricorda che devi <span class="rosso">selezionare di volta in volta <strong>S&igrave;</strong> nel primo campo</span> e poi le <strong>singole zone</strong> in tutti gli altri campi (Regioni, Province, ecc.).</p>
<p>Campi obbligatori: tutti.</p>
<br /><br /><br /><br /><br />
</div>
</div>


<?php
} // OPZIONE PROMOZIONI ATTIVE
else { 
?>    
<form id="nuovo00" method="post" action="?"><br />
<p>Le zone in cui apparir&agrave; l'Articolo sono:</p>
<p class="riquadro testo">
<?php
print "Regione: ".ucwords($regione)."<br />";
print "Provincia: ".ucwords($regione)."<br />";
print "Comune: ".ucwords($comune)."<br />";
if ($idM>0){ print "Municipio: ".ucwords($municipio)."<br />"; }
if ($idQ>0){ print "Quartiere: ".ucwords($quartiere)."<br />"; }
?>
</p>
<input type="hidden" name="conferma" value="n" />
<p><br /><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">La modifica dei Luoghi &egrave; riservata esclusivamente a coloro che hanno attivato l'opzione <span class="verde"><strong>promozioni</strong></span>, grazie alla quale possono far apparire gli articoli in zone diverse da quelle in cui operano le rispettive Attivit&agrave;.</p>
<br /><br /><br /><br /><br />
</div>
</div>

<?php
}
include "../footer.php";
?>
