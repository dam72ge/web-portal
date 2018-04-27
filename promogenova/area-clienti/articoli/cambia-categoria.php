<?php
// idArt
if (!isset($_GET['idArt'])) {
header ("location: index.php");
}
$idArt=$_GET['idArt'];

// redirect finale
$redirUrl="articoliModif.php?idArt=".$idArt;

$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;
require_once "../../config/class_admin_clienti.php"; $mysql=new mysql;

// riconosci cliente
$cfrAtt=$mysql->cliente_articolo($conn,$idArt);
if ($idAttivita!=$cfrAtt) {
header ("location: $redirUrl ");
}

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
      
            $sql="UPDATE articoli_dat SET  
            idMacro='".mysqli_real_escape_string($conn,stripslashes($art_idMacro))."' 
            WHERE idArt='".$idArt."'";
            $query=mysqli_query($conn,$sql);
      
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
}

// struttura html
$title="Admin ".$attivita." - Articolo ".$idArt." - ".$art_titolo." - Modifica categoria";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica la categoria dell'articolo n.ro <?php print $idArt; ?></h3><br />
<br />
<form id="nuovo00" method="post" action="?idArt=<?php print $idArt; ?>">

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
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<p>
Per tornare al Men&ugrave; dell'Articolo clicca <a href="<?php print $redirUrl; ?>">QUI</a> oppure sul bottone SALVA.
</p>
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
