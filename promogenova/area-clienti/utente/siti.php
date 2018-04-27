<?php
$url="../../"; $urlAdm="../"; 
include "../inc/apri.php";
include "../../config/mydb.php";

// carica elementi comuni layout
require_once "../../config/class_layout.php"; $myobj=new pagina;

// reg su db
$msgErr="";
$msgSalv="";


// banner: data+estensione
$oggiHis=date('YmdHis');
$loadImg="";
if(isset($_FILES['newImg']['name'])){
   $ext=strtolower(pathinfo($_FILES['newImg']['name'],PATHINFO_EXTENSION));
   $urlCompleto=$url.$cartella."/banner-".$oggiHis.".".$ext;
   @rename($_FILES['newImg']['tmp_name'], $urlCompleto);
   $dirImg=$url.$cartella."/";
   $loadImg="banner-".$oggiHis.".".$ext;   
    // modifica banner (max: width 500, height 250)
	$myobj->creathumb($dirImg,$loadImg,500,250,$dirImg,"");
}


// NUOVO 
if (isset($_POST['upd']) && $_POST['upd']=="s") {
    
    // controllo
    if ($_POST['newUrl']==""){
    $msgErr="Devi inserire un indirizzo (URL) che rimandi alla tua pagina/url internet";
    }
    else{
    $msgErr=$myobj->ctrlSito($_POST['newUrl']);
    }

    // SALVATAGGIO
    if ($msgErr==""){

    $sql = 
    "
    INSERT INTO vetrine_siti 
    (id,idAttivita,tipo,descriz,url,banner) 
    VALUES 
    ( 
    '',
    '".mysqli_real_escape_string($conn,stripslashes($idAttivita))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newTipo']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newDescriz']))."',
    '".mysqli_real_escape_string($conn,stripslashes($_POST['newUrl']))."',
    '".mysqli_real_escape_string($conn,stripslashes($loadImg))."'
    )";
    $query=mysqli_query($conn,$sql);

    // id nuovo
   	$idNuovoINS=mysqli_insert_id($conn);
      
    $_POST['upd']="n";
    $msgSalv="Il sito &egrave; stato aggiunto.";
    }
}

// ELIMINA 
if (isset($_POST['rimoz']) && $_POST['rimoz']=="s") {
   $urlFile=$url.$cartella."/".$_POST['oldImg'];
   if (file_exists($urlFile)) { unlink($urlFile);}   
   $sql="DELETE FROM vetrine_siti WHERE id='".$_POST['id']."'"; 
   $query=mysqli_query($conn,$sql);   
   $_POST['id']=0;
   $msgSalv="Il sito &egrave; stato rimosso.";
}

// RIMUOVI SOLO IMG
if (isset($_POST['selImg']) && $_POST['selImg']=="s") {
   $urlFile=$url.$cartella."/".$_POST['oldImg'];
   if (file_exists($urlFile)) { unlink($urlFile);}
   $loadImg==""; $_POST['oldImg']="";
      $sql="UPDATE vetrine_siti SET 
	  banner=''
	  WHERE id='".$_POST['id']."'";
      $query=mysqli_query($conn,$sql);
}

// MODIFICA 
if (isset($_POST['id']) && $_POST['id']>0) {
    
    // controllo
    if ($_POST['newUrl']==""){
    $msgErr="Devi inserire un indirizzo (URL) che rimandi alla tua pagina/url internet";
    }
    else{
    $msgErr=$myobj->ctrlSito($_POST['newUrl']);
    }

    // immagine
    if ($loadImg==""){
    $loadImg=$_POST['oldImg'];
    }

    // SALVATAGGIO
    if ($msgErr==""){

      $sql="UPDATE vetrine_siti SET 
	  tipo='".mysqli_real_escape_string($conn,stripslashes($_POST['newTipo']))."', 
	  descriz='".mysqli_real_escape_string($conn,stripslashes($_POST['newDescriz']))."', 
	  url='".mysqli_real_escape_string($conn,stripslashes($_POST['newUrl']))."',
	  banner='".mysqli_real_escape_string($conn,stripslashes($loadImg))."'
	  WHERE id='".$_POST['id']."'";
      $query=mysqli_query($conn,$sql);
      
      $_POST['id']=0;
      $msgSalv="Le modifiche sono state salvate.";
    }
}

// leggi db
    $totSiti=0;
    $siti=array(
	"id" => array (""),
	"descriz" => array (""),
	"tipo" => array (""),
	"url" => array (""),
	"banner" => array ("")
    );

    $sql="SELECT id,tipo,descriz,url,banner FROM vetrine_siti WHERE idAttivita='".$idAttivita."' ORDER BY id ASC";
    $query=mysqli_query($conn,$sql);			
    while($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $siti['id'][]=$q['id'];
    $siti['tipo'][]=$q['tipo'];
    $siti['descriz'][]=$q['descriz'];
    $siti['url'][]=$q['url'];
    $siti['banner'][]=$q['banner'];
    $totSiti++;
    }


// struttura html
$title="Admin ".$attivita." - Pagine e Siti internet";
$metaDescription="";
$metaKeywords="";
$metaRobots="NONE";

include "../head.php";
include "../header-nav.php";
?>

<div class="riga">
<div class="colonna-1-2">
<h4>Pagine e Siti internet</h4><br />
<?php
if ($totSiti>0) {
if ($msgErr!="") {
print "<span class='rosso'>".$msgErr."</span><br /><br />";
}
if ($msgSalv=="") {

    for ($i=1;$i<count($siti['id']);$i++) {
        print "<h5>Sito: ".$i." di ".$totSiti."</h5>";
        print "<form id='modifUrl_".$siti['id'][$i]."' method='post' enctype='multipart/form-data' action='?' class='riquadro'>";

        $icona="";
        switch ($siti['tipo'][$i]){ 
        	case "Sito": $icona="sito.png"; break;
        	case "Sito e-commerce": $icona="ecommerce.png"; break;
        	case "Pagina facebook": $icona="facebook.png"; break;
        	case "Gruppo facebook": $icona="facebook.png"; break;
        	case "Blog": $icona="blogger.png"; break;
        }

        print "<p><label>Tipo di sito/pagina";       
            if ($icona!="") { print " <img src='".$url."/ico/".$icona."' alt='".$icona."' />";	}
        print "</label><br />";
        print "<select name='newTipo' option='1'>";
        print "<option value='Sito'"; if ( $siti['tipo'][$i]=="Sito") { print " selected";}  print ">Sito internet</option>";
        print "<option value='Sito e-commerce'"; if ( $siti['tipo'][$i]=="Sito e-commerce") { print " selected";}  print ">Sito e-commerce</option>";
        print "<option value='Pagina facebook'"; if ( $siti['tipo'][$i]=="Pagina facebook") { print " selected";}  print ">Pagina facebook</option>";
        print "<option value='Gruppo facebook'"; if ( $siti['tipo'][$i]=="Gruppo facebook") { print " selected";}  print ">Gruppo facebook</option>";
        print "<option value='Blog'"; if ( $siti['tipo'][$i]=="Blog") { print " selected";}  print ">Blog</option>";
        print "</select><br />";
        print "<p><label>Url sito/pagina (come da <a href='#esempio'>esempio</a>)</label><br />";
        print "<textarea name='newUrl' rows='1' cols='30' required>".$siti['url'][$i]."</textarea></p>";
        print "<p><label>Descrizione</label><br />";
        print "<textarea name='newDescriz' rows='4' cols='30'>".$siti['descriz'][$i]."</textarea></p>";

        if ($siti['banner'][$i]!="") {
            print "<p><img src='".$url.$cartella."/".$siti['banner'][$i]."' alt='' class='scala' /><br />";
            print "<label>Rimuovere questo banner?</label><br />";
            print "<select name='selImg' option='1'>";
            print "<option value='n' selected>No, mantienilo</option>";
            print "<option value='s'>S&igrave;, rimuovilo dal database</option>";
            print "</select></p>";
        } 
        else{            
            print "<input type='file' name='newImg' value='' class='bottFile' /></p>";
            print "<p class='button'>Carica un banner</p>";
        } 

        print "<p><label>Rimuovere questo <strong>sito</strong>?</label><br />";
        print "<select name='rimoz' option='1'>";
        print "<option value='n' selected>No, confermalo</option>";
        print "<option value='s'>S&igrave;, rimuovilo dal database</option>";
        print "</select></p>";

        print "<input type='hidden' name='oldImg' value='".$siti['banner'][$i]."'/>";
        print "<input type='hidden' name='id' value='".$siti['id'][$i]."'/>";
        print "<p><input type='submit' name='salva' value='SALVA' class='bottSubmit' /></p>";
        print "</form><br /><br /><br />";
	}
}
else{
print "<h2 class='verde'>".$msgSalv."</h2>";
print "<a href='../'>Torna al Men&ugrave; principale</a> oppure <a href='?'>Visualizza e modifica di nuovo.</a><br /><br />";	
}
}
?>
<h5 class="verde">Aggiungi un Sito o una Pagina internet</h5>
<form id="nuovoTipo" method="post" enctype="multipart/form-data" action="?">

  <p><label>Seleziona un Tipo di sito o pagina<label><br />
  <select name="newTipo" option="1">
  <option value="Sito" selected>Sito ufficiale</option>
  <option value="Sito e-commerce">Sito ufficiale e-commerce</option>
  <option value="Pagina facebook">Pagina facebook</option>
  <option value="Gruppo facebook">Gruppo facebook</option>
  <option value="Blog">Blog</option>
  </select></p>
  
  <p><label>Nome (Profilo, Contatto o Nome pagina/gruppo ecc.)<label><br />
  <input type="text" size="30" name="newDescriz" value="" required /></p>
  
  <p><label for="url">Url (indirizzo internet come da <a href="#esempio">esempio</a>)<label><br />  
  <textarea name="newUrl" id="url" rows="3" cols="30" required></textarea><br /><br /></p> 


  <input type="file" name="newImg" value="" class="bottFile" />
  <p class="button">Carica un banner</p>

  <input type="hidden" name="upd" value="s" />
  <p><input type="submit" name="salva" value="SALVA" class="bottSubmit"  /></p>
</form>
<br /><br /><br />
</div>
<div class="colonna-1-2">
<p class="testo">Per essere accettata, l'indirizzo della <b>Pagina</b> o del <b>Sito</b> devono essere validi e rispettare le condizioni di trasparenza, rispetto della <em>privacy</em> e affidabilit&agrave; (attenzione: siti infettati da virus e/o siti che rimandano ad altri siti saranno rimossi all'istante e <span class="rosso">la vetrina verr&agrave; temporaneamente oscurata senza preavviso</span>).<br /> L'indirizzo <b>Url</b> deve inoltre comprendere la parte iniziale (<span class="rosso">http://</span>) altrimenti non sar&agrave; considerato valido.<br />
Attenzione! Se desideri pubblicare soltanto il tuo <b>profilo personale</b>, vai su <a href="social.php">Profili e contatti sui social network</a>.</p>
<p>Campi obbligatori: <strong>Tipo</strong> e <strong>Url</strong>.
<br /><br />
<?php include "../inc/es-url.php"; ?></p>
</div>
</div>
<?php
include "../footer.php";
?>
