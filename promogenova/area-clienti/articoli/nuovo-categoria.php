<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
if (isset($_POST['art_idMacro']) && $_POST['art_idMacro']>0) {
    
    // id ->  categoria
    $art_idMacro=$_POST['art_idMacro'];
        $sqlm="SELECT macro FROM macro WHERE idMacro='".$_POST['art_idMacro']."'";
        $querym=mysqli_query($conn,$sqlm);
        $m=mysqli_fetch_array($querym,MYSQLI_ASSOC);
        $art_macro=$m['macro'];

    // SALVATAGGIO IN SESSIONE
    $categ=$myobj->mb_convert_encoding($art_macro);

      $_SESSION['art_macro']=$categ; $_POST['art_macro']=$categ;
      $_SESSION['art_idMacro']=$art_idMacro; $_POST['art_idMacro']=$art_idMacro;
      $_POST['upd']="n";
      
      // passa automaticamente al prossimo step
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-pubblica.php';\n"; 
  echo "</script>"; 
      //header("location: nuovo-promozione.php");
}

// struttura html
$title="Admin ".$attivita." - Nuovo articolo - Step 4 di 5: Categoria commerciale";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Articolo - Passaggio 4 di 5: Categoria</h4>

<?php
if ($_SESSION['art_titolo']!="" && $_SESSION['art_testo']!="" && $_SESSION['art_idMacro']>0){ 
?>
<a href="nuovo.php">1 Titolo</a> | 
<a href="nuovo-testo.php">2 Testo</a> | 
<a href="nuovo-immagine.php">3 Immagine</a> | 
<a href="nuovo-categoria.php">4 Categoria comm.le</a> | 
<a href="nuovo-pubblica.php">5 Anteprima e Pubblicazione</a>
<br />
<?php    
}
?>

<form id="nuovo00" method="post" action="?">

  <p><label for="categoriaArt">Categoria commerciale<label><br />
  <select name="art_idMacro" options="1">
<?php
        $sqlm="SELECT idMacro,macro FROM macro ORDER BY macro ASC";
        $querym=mysqli_query($conn,$sqlm);
        while ($m=mysqli_fetch_array($querym,MYSQLI_ASSOC)) {
        $nomecateg=$myobj->mb_convert_encoding($m['macro']);
            print "<option value='".$m['idMacro']."'";
            if ($m['idMacro']==$art_idMacro) { print " selected"; }
            print ">".ucfirst($nomecateg)."</option>";
        }
?>
  </select>
  </p>
  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<p>Torna al <a href="index.php">Menu articoli</a> | Torna all'<a href="../">Inizio</a></p>

<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Scegli la <strong>categoria commerciale</strong> pi&ugrave; affine al tipo di articolo che stai creando.</p>
<p>Campi obbligatori: tutti.</p>
<br /><br /><br />
<h5 class="arancio">Categorie commerciali per esteso</h5>
<?php
        $sqlm="SELECT macro,descriz FROM macro ORDER BY macro ASC";
        $querym=mysqli_query($conn,$sqlm);
        while ($m=mysqli_fetch_array($querym,MYSQLI_ASSOC)) {
        $nomecateg=$myobj->mb_convert_encoding($m['macro']);
        $descriz=$myobj->mb_convert_encoding($m['descriz']);
            print "<p><span class='nero'>".ucfirst($nomecateg)."</span>:".$descriz."</p>";
        }
?>

<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
