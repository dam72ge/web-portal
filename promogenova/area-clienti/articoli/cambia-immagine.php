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
    
        // copia il file
        if ($msgErr==""){
        $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
        $nomedir=$idArt.".".$ext;
        $urlFile=$url.$cartella."/articoli/".$nomedir;

        // salva file
        @rename($_FILES['newImg']['tmp_name'], $urlFile);

        // crea thumb 
        $dirFile=$url.$cartella."/articoli/";
        $myobj->creathumb($dirFile,$nomedir,200,200,$dirFile,"th_");
        $myobj->creathumb($dirFile,$nomedir,48,48,$dirFile,"ico_");

        // aggiorna sessione
        $_SESSION['art_img']=$nomedir; $art_img=$nomedir;
        $_POST['upd']="n";

            $sql="UPDATE articoli SET  
            img='".mysqli_real_escape_string($conn,stripslashes($art_img))."' 
            WHERE idArt='".$idArt."'";
            $query=mysqli_query($conn,$sql);
        }
   }
   // passa automaticamente al prossimo step
   if ($msgErr==""){
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
   }
}

// RIMUOVI SOLO IMG
if (isset($_POST['selImg']) && $_POST['selImg']=="s") {
   $urlFile=$url.$cartella."/articoli/".$art_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url.$cartella."/articoli/th_".$art_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url.$cartella."/articoli/ico_".$art_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   
      $_SESSION['art_img']=""; 
      $art_img="";      
      $_POST['upd']="n";
            $sql="UPDATE articoli SET  
            img='' 
            WHERE idArt='".$idArt."'";
            $query=mysqli_query($conn,$sql);
}
// RIMUOVI SOLO IMG
if (isset($_POST['selImg']) && $_POST['selImg']=="n") {
      //header ("location: $redirUrl ");
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
}
 

// struttura html
$title="Admin ".$attivita." - Articolo ".$idArt." - ".$art_titolo." - Modifica immagine";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica l'immagine dell'articolo n.ro <?php print $idArt; ?></h3><br />
<br />
<?php
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br /><br />";
}

print "<form id='modifLogo' method='post' enctype='multipart/form-data' action='?idArt=".$idArt."' class='riquadro'>";
        if ($art_img!="") {
            print "<p><img src='".$url.$cartella."/articoli/".$art_img."' alt='immagine_allegata' class='scala' /><br />";
            print "<label>Rimuovere questa immagine?</label><br />";
            print "<select name='selImg' option='1'>";
            print "<option value='n' selected>No, mantienila</option>";
            print "<option value='s'>S&igrave;, rimuovila dal database</option>";
            print "</select></p>";
        } 
        else{            
            print "<input type='file' name='newImg' value='' class='bottFile' /></p>";
            print "<p class='button'>Carica un'immagine</p>";
        } 

print "<input type='hidden' name='upd'' value='s' />";
print "<p><input type='submit' name='salva' value='SALVA' class='bottSubmit' /></p>";
print "</form>";
?>
<p>
Per tornare al Men&ugrave; dell'Articolo clicca <a href="<?php print $redirUrl; ?>">QUI</a> oppure sul bottone SALVA.
</p>
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
