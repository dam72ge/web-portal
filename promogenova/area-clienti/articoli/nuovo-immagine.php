<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";

if (isset($_FILES['newImg']['name'])){
    // controlli    
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
   // passa automaticamente al prossimo step
   if ($msgErr==""){
  echo "<script language=\"JavaScript\">\n";
  echo "location.href='nuovo-categoria.php';\n"; 
  echo "</script>"; 
      //header("location: nuovo-categoria.php");
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
 

// struttura html
$title="Admin ".$attivita." - Nuovo articolo - Step 3 di 5: Immagine";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Crea un Articolo - Passaggio 3 di 5: Immagine</h4>
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

if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}

print "<form id='modifLogo' method='post' enctype='multipart/form-data' action='?' class='riquadro'>";
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
            print "<br/><br/><input type='file' name='newImg' value='' /></p>"; //  class='bottFile'
            //print "<p class='button'>Carica un'immagine</p>";
        } 

print "<input type='hidden' name='upd'' value='s' />";
print "<p><input type='submit' name='salva' value='SALVA E VAI AVANTI' class='bottSubmit' /></p>";
print "</form>";
?>
<p>Torna al <a href="index.php">Menu articoli</a> | Torna all'<a href="../">Inizio</a></p>
<br /><br /><br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettata, l'immagine deve essere in formato JPG e non deve pesare pi&ugrave; di 2 MB.</p>
<p>Campi obbligatori: nessuno. Puoi eventualmente saltare questo passaggio e caricare l'immagine in un secondo momento.</p>
<br /><br /><br /><br /><br />
</div>
</div>
<?php
include "../footer.php";
?>
