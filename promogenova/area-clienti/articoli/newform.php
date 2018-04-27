<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
if (isset($_POST['upd']) && $_POST['upd']!="n") {
$new_titolo=$myobj->convTitle($_POST['art_titolo']); // formatta testo
$new_testo=$mysql->formattaTxt($_POST['art_testo']);

    // CONTROLLI TITOLO
    if ($new_titolo==""){
    $msgErr="Il campo titolo non pu&ograve; essere lasciato vuoto.";
    }
    if ($msgErr=="") { $msgErr=$myobj->contaCaratteri($new_titolo,3,120); }
    if ($msgErr=="") { $msgErr=$myobj->minimoParole($new_titolo,1); }
    if ($msgErr=="") { $msgErr=$myobj->checkTag($new_titolo); }
    if ($msgErr=="") { $msgErr=$myobj->checkMaiu($new_titolo); }
    // no doppioni
    if ($msgErr==""){
        $sqldopp="SELECT titolo FROM articoli WHERE titolo LIKE '".$_POST['art_titolo']."'";
        $querydopp=@mysqli_query($conn,$sqldopp);
        $dopp=@mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
        if ($dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo titolo!"; }
    }
    if ($msgErr==""){
        $sqldopp="SELECT titolo FROM articoli WHERE titolo LIKE '".$new_titolo."'";
        $querydopp=@mysqli_query($conn,$sqldopp);
        $dopp=@mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
        if ($dopp['titolo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo titolo!"; }
    }

    // CONTROLLI TESTO
    if ($new_testo==""){
    $msgErr="Il campo testo non pu&ograve; essere lasciato vuoto.";
    }
    if ($msgErr=="") { $msgErr=$myobj->minimoParole($new_testo,5); }
    if ($msgErr=="") { $msgErr=$myobj->checkMaiu($new_testo); }

	// codici html (ammessi tutti tranne div, form, php...)
    if ($msgErr=="") { $msgErr=$myobj->checkHtml($new_testo); }

    // no doppioni
    if ($msgErr==""){
        $sqldopp="SELECT testo FROM articoli_txt WHERE testo LIKE '".mysqli_real_escape_string($conn,$new_testo)."'";
        $querydopp=mysqli_query($conn,$sqldopp);
        $dopp=mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
    if (isset($dopp['testo']) && $dopp['testo']!=""){ $msgErr="Esiste gi&agrave; un articolo con questo testo!"; }
    }


	// CONTROLLO IMMAGINE
	if (isset($_FILES['newImg']['name'])){
	if ($_FILES['newImg']['name']!=""){
        $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));

        $file_size = $_FILES['newImg']['size'];// restituisce la grandezza del file
   
        if ($msgErr=="" && $file_size==0){
            $msgErr="Il server non riesce a caricare il file e/o a completare l'operazione. Prova a cambiare immagine.";
            }
        if ($msgErr==""){ $msgErr=$myobj->ctrlExtFile($ext,"jpg"); }// formato unico ammesso 
        if ($msgErr==""){ $msgErr=$myobj->ctrlPesoFile($file_size,2); }// limite peso 
        // no doppioni
        if ($msgErr=="" && isset($_POST['newImg']) && $_POST['newImg']!=""){
            $sqldopp="SELECT img FROM articoli WHERE img LIKE '".mysqli_real_escape_string($conn,stripslashes($_POST['newImg']))."'";
            $querydopp=mysqli_query($conn,$sqldopp);
            $dopp=mysqli_fetch_array($querydopp,MYSQLI_ASSOC);
            if (isset($dopp['img']) && $dopp['img']!=""){ $msgErr="Esiste gi&agrave; un file con questo nome!"; }
        }
        // copia il file temporaneamente
        if ($msgErr==""){
        $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
        $nomedir="nuovoart.".$ext;
        $urlFile=$url.$cartella."/".$nomedir;

        // salva file
        @rename($_FILES['newImg']['tmp_name'], $urlFile);

        // crea thumb provvisorie
        $dirFile=$url.$cartella."/";
        $myobj->creathumb($dirFile,$nomedir,200,200,$dirFile,"th_");
        $myobj->creathumb($dirFile,$nomedir,48,48,$dirFile,"ico_");

        // aggiorna sessione
        $_SESSION['art_img']=$nomedir; $art_img=$nomedir;
        $_POST['upd']="n";
        }
   }
   }

 

// RIMUOVI SOLO IMG
if (isset($_POST['selImg']) && $_POST['selImg']=="s") {
   $urlFile=$url.$cartella."/".$art_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url.$cartella."/th_".$art_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url.$cartella."/ico_".$art_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   
      $_SESSION['art_img']=""; 
      $art_img="";      
      $_POST['upd']="n";
}
// RIMUOVI SOLO IMG
if (isset($_POST['selImg']) && $_POST['selImg']=="n") {
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-categoria.php';\n"; 
  echo "</script>"; 
      //header("location: nuovo-categoria.php");
}


// SALVATAGGIO IN SESSIONE
    if ($msgErr==""){

      $art_titolo=$myobj->convTitle($_POST['art_titolo']); // formatta titolo
      $_SESSION['art_titolo']=$art_titolo; $_POST['art_titolo']=$art_titolo;
      $_POST['upd']="n";

      // passa automaticamente al prossimo step
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-testo.php';\n"; 
  echo "</script>"; 
    }
}

// struttura html
$title="Admin ".$attivita." - Crea nuovo articolo al volo";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Articolo al volo</h4>
Compila TUTTI i campi e presta attenzione: se sbagli ricominci da capo!<br/><br/>

<?php    
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}
?>

<form id="nuovo00" method="post" enctype="multipart/form-data" action="?">

  <p><label for="titoloArt">Titolo dell'Articolo<label><br />
  <textarea name="art_titolo" id="titoloArt" rows="5" cols="30" autofocus required><?php print $art_titolo; ?></textarea></p>

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


</div>
<div class="colonna-1-2">
<?php
        $urlAntep=$url.$cartella."/".$art_img;
        if ($art_img!="" && file_exists($urlAntep)) {
            print "<p><img src='".$url.$cartella."/".$art_img."' alt='immagine_provvisoria' class='scala' /><br />";
            print "<label>Rimuovere questa immagine?</label><br />";
            print "<select name='selImg' option='1'>";
            print "<option value='n' selected>No, mantienilo</option>";
            print "<option value='s'>S&igrave;, rimuovilo dal database</option>";
            print "</select></p>";
        } 
        else{            
            print "<p></p><label>Carica un'immagine</label><br/>";
            print "<input type='file' name='newImg' value='' /></p>";
        } 

?>
  <p><label for="testoArt">Testo dell'Articolo (<?php print $totParole;?> parole)<label><br />
  <textarea name="art_testo" id="testoArt" rows="10" cols="30" autofocus required><?php print $art_testo; ?></textarea></p>

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA E VAI AVANTI" class="bottSubmit"  /></p>
</form>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
