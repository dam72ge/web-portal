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

// recupera immagine
$idMedia=0;
$ev_img="";
$sql1="
SELECT media.idMedia,img 
FROM media,media_link 
WHERE media_link.idMedia=media.idMedia
AND media_link.id='".$id."'
";
$query1=mysqli_query($conn,$sql1);			
$row=mysqli_fetch_array($query1,MYSQLI_ASSOC);
	if ($row['img']!="" ) { 
	$idMedia=$row['idMedia']; 
	$ev_img=$row['img']; 
	}


// reg su db
$msgErr="";

if (isset($_FILES['newImg']['name']) && $_FILES['newImg']['name']!=""){

    // controlli    
        $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));

        $file_size = $_FILES['newImg']['size'];// restituisce la grandezza del file
   
        if ($msgErr=="" && $file_size==0){
            $msgErr="Il server non riesce a caricare il file e/o a completare l'operazione. Prova a cambiare immagine.";
            }
        if ($msgErr==""){ $msgErr=$myobj->ctrlExtFile($ext,"jpg"); }// formato unico ammesso 
        if ($msgErr==""){ $msgErr=$myobj->ctrlPesoFile($file_size,2); }// limite peso 
        // no doppioni
        if ($msgErr=="" && isset($_POST['newImg']) && $_POST['newImg']!=""){
            $sqldopp="SELECT img FROM eventi WHERE img LIKE '".mysqli_real_escape_string($conn,stripslashes($_POST['newImg']))."'";
            $querydopp=mysql_query($sqldopp);
            $dopp=mysql_fetch_array($querydopp);
            if (isset($dopp['img']) && $dopp['img']!=""){ $msgErr="Esiste gi&agrave; un file con questo nome!"; }
        }
    

        // aggiungi a media e medialink
        if ($msgErr==""){

			$sql = 
			"
			INSERT INTO media
			(idMedia,img) 
			VALUES 
			( 
			'',
			''
			)";
			$query=mysqli_query($conn,$sql);
			$idNuovoMedia=mysqli_insert_id($conn);

			$sql = 
			"
			INSERT INTO media_link
			(idML,idMedia,id,idAlbum,idVideo) 
			VALUES 
			( 
			'',
			'".$idNuovoMedia."',
			'".$id."',
			'0',
			'0'
			)";
			$query=mysqli_query($conn,$sql);

			// copia il file
			$ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
			$nomedir=$idNuovoMedia.".".$ext;
			$urlFile=$url."locandine/".$nomedir;

			// registra su media
            $sql="UPDATE media SET  
            img='".$nomedir."' 
            WHERE idMedia='".$idNuovoMedia."'";
            $query=mysqli_query($conn,$sql);

			// salva file
			@rename($_FILES['newImg']['tmp_name'], $urlFile);

			// crea thumb
			$dirFile=$url."locandine/";
			$myobj->creathumb($dirFile,$nomedir,200,200,$dirFile,"th_");
			$myobj->creathumb($dirFile,$nomedir,48,48,$dirFile,"ico_");

			// aggiorna sessione
			$_SESSION['ev_img']=$nomedir; $ev_img=$nomedir;
			$_POST['upd']="n";
            
   }
 
   // passa automaticamente al prossimo step
   if ($msgErr==""){
        echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
        echo "</script>"; 
      //header("location: nuovo-pubblica.php");
   }
}

// RIMUOVI IMG
if (isset($_POST['selImg']) && $_POST['selImg']=="s" && isset($_POST['idMedia'])) {

   $urlFile=$url."locandine/".$ev_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."locandine/th_".$ev_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $urlFile=$url."locandine/ico_".$ev_img;
   if (file_exists($urlFile)) { unlink($urlFile);}   

   $sql="UPDATE media SET  
   img='' 
   WHERE idMedia='".$_POST['idMedia']."'";
   $query=mysqli_query($conn,$sql);

   $sql="UPDATE media_link SET  
   id='0' 
   WHERE idMedia='".$_POST['idMedia']."'";
   $query=mysqli_query($conn,$sql);

      $_SESSION['ev_img']=""; 
      $ev_img="";      
      $_POST['upd']="n";
}
// MANTIENI IMG
if (isset($_POST['selImg']) && $_POST['selImg']=="n") {
  echo "<script language=\"JavaScript\">\n";
        echo "location.href='".$redirUrl."';\n"; 
  echo "</script>"; 
      
      //header("location: nuovo-pubblica.php");
}
 
// struttura html
$title="Admin ".$attivita." - Evento ".$id." - Modifica immagine (locandina)";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h3 class="rosso">Modifica l'immagine (locandina) dell'evento n.ro <?php print $id; ?></h3><br />
<br />
<?php
if ($msgErr!="") {
print "<br /><br /><span class='rosso'>".$msgErr."</span><br />";
}
print "<br /><br />";
print "<form id='modifImg' method='post' enctype='multipart/form-data' action='?id=".$id."' class='riquadro actr'>";
        $urlAntep=$url."locandine/".$ev_img;
        if ($ev_img!="" && file_exists($urlAntep)) {
            print "<p><img src='".$url."locandine/".$ev_img."' alt='immagine_provvisoria' class='scala' /><br />";
            print "<label>Rimuovere questa immagine?</label><br />";
            print "<select name='selImg' option='1'>";
            print "<option value='n' selected>No, mantienilo</option>";
            print "<option value='s'>S&igrave;, rimuovilo dal database</option>";
            print "</select></p>";
        } 
        else{            
            print "<label>Carica un'immagine</label><br/>";
            print "<input type='file' name='newImg' value='' /></p>";
        } 

print "<input type='hidden' name='idMedia' value='".$idMedia."' />";
print "<input type='hidden' name='ev_img'' value='".$ev_img."' />";
print "<input type='hidden' name='upd'' value='s' />";
print "<p><input type='submit' name='salva' value='SALVA E VAI AVANTI' class='bottSubmit' /></p>";
print "</form>";
?>
<p><a href="<?php print $redirUrl; ?>">Torna all'Evento</a></p>
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
