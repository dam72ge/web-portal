<?php
$url="../../../"; $urlAdm="../../";  
include "../inc/apri.php";
?>
<h3><a href="../inizio.php">Inizio</a> | <a href="../attivita">Attivita'</a> | ELIMINA CLIENTI</h3>

<?php
// rimozione
if (isset($_GET['id'])) {
$id=$_GET['id'];

     // recupera cartella
	$sql="SELECT cartella FROM vetrine WHERE idAttivita='".$id."'";    
	 $query=mysqli_query($conn,$sql);
	 $q=mysqli_fetch_array($query,MYSQLI_ASSOC);
    $cartella=$q['cartella'];


    // ELIMINA ARTICOLI
    
	$tot=0;
    $sql="SELECT articoli.idArt,img FROM articoli_dat,articoli WHERE articoli.idArt=articoli_dat.idArt AND idAttivita='".$id."'";    
	 $query=mysqli_query($conn,$sql);
	 while ($q=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
	$articoli['idArt'][]=$q['idArt'];
	$articoli['img'][]=$q['img'];
    $tot++;
    }

    if($tot>0) {
	
        for ($i=0;$i<count($articoli['idArt']);$i++) {
        
        $urlFile=$url.$cartella."/articoli/".$articoli['img'][$i];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url.$cartella."/articoli/ico_".$articoli['img'][$i];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url.$cartella."/articoli/th_".$articoli['img'][$i];
        if (file_exists($urlFile)) { unlink($urlFile);}   
           
            $sql1="DELETE FROM articoli WHERE idArt='".$articoli['idArt'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      
            $sql1="DELETE FROM articoli_dat WHERE idArt='".$articoli['idArt'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      
            $sql1="DELETE FROM articoli_txt WHERE idArt='".$articoli['idArt'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      
            $sql1="DELETE FROM articoli_promo WHERE idArt='".$articoli['idArt'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      

        }
    }

    
    // ELIMINA EVENTI (SOLO DEL CLIENTE)

    // eventi promot
    $tot=0;
	$sql="SELECT eventi_promot.id,img FROM eventi_promot,eventi WHERE eventi.id=eventi_promot.id AND home='n' AND idAttivita='".$id."' AND idRete='0'";    
    $query=mysqli_query($conn,$sql);
    while ($q=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
	$eventi['id'][]=$q['id'];
	$eventi['img'][]=$q['img'];
    $tot++;
    }
    // eventi
    if($tot>0) {
	
        for ($i=0;$i<count($eventi);$i++) {
        
        $urlFile=$url."eventi/locandine/".$eventi['img'][$i];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url."eventi/locandine/th_".$eventi['img'][$i];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url."eventi/locandine/ico_".$eventi['img'][$i];
        if (file_exists($urlFile)) { unlink($urlFile);}   
           
            $sql1="DELETE FROM eventi WHERE id='".$eventi['id'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      
            $sql1="DELETE FROM eventi_dateore WHERE id='".$eventi['id'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      
            $sql1="DELETE FROM eventi_link WHERE id='".$eventi['id'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      
            $sql1="DELETE FROM eventi_promot WHERE id='".$eventi['id'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      
            $sql1="DELETE FROM eventi_txt WHERE id='".$eventi['id'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      
            $sql1="DELETE FROM eventi_zone WHERE id='".$eventi['id'][$i]."'";
            $query1=mysqli_query($conn,$sql1);      

        }
    }


    // ELIMINA VETRINA

    // foto
	$sql="SELECT foto FROM vetrine_foto WHERE idAttivita='".$id."'";    
    $query=mysqli_query($conn,$sql);
    while ($q=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
        $urlFile=$url.$cartella."foto/".$q['foto'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url.$cartella."foto/th_".$q['foto'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url.$cartella."foto/ico_".$q['foto'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
    }
    $sql1="DELETE FROM vetrine_foto WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    
    // siti
	$sql="SELECT banner FROM vetrine_siti WHERE idAttivita='".$id."'";    
    $query=mysqli_query($conn,$sql);
    while ($q=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
        $urlFile=$url.$cartella."/".$q['banner'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url.$cartella."/th_".$q['banner'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url.$cartella."/ico_".$q['banner'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
    }
    $sql1="DELETE FROM vetrine_siti WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      

    // social
    $sql1="DELETE FROM vetrine_social WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    // chisiamo
    $sql1="DELETE FROM vetrine_chisiamo WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    // email
    $sql1="DELETE FROM vetrine_email WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    // marchi
    $sql1="DELETE FROM vetrine_marchi WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    // orari
    $sql1="DELETE FROM vetrine_orari WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    // reti
    $sql1="DELETE FROM vetrine_reti WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    // tag
    $sql1="DELETE FROM vetrine_tag WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    // telefoni
    $sql1="DELETE FROM vetrine_telefoni WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    // video
    $sql1="DELETE FROM vetrine_video WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    

    // logo
	$sql="SELECT logo FROM vetrine WHERE idAttivita='".$id."'";    
    $query=mysqli_query($conn,$sql);
    $q=mysqli_fetch_array($query,MYSQLI_ASSOC);
        $urlFile=$url.$cartella."/".$q['logo'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url.$cartella."/th_".$q['logo'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
        $urlFile=$url.$cartella."/ico_".$q['logo'];
        if (file_exists($urlFile)) { unlink($urlFile);}   
    
    // cartelle vetrina
    $dirCart=$url.$cartella."/articoli"; rmdir($dirCart);
    $dirCart=$url.$cartella."/foto"; rmdir($dirCart);
    $urlFile=$url.$cartella."/articoli.php"; unlink($urlFile);   
    $urlFile=$url.$cartella."/foto.php"; unlink($urlFile);   
    $urlFile=$url.$cartella."/index.php"; unlink($urlFile);   
    $dirCart=$url.$cartella; rmdir($dirCart);

    // vetrina
    $sql1="DELETE FROM vetrine WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      


    // ELIMINA CLIENTE

    // att_clienti_contatti
    $sql1="DELETE FROM att_clienti_contatti WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      

    // att_indirizzi
    $sql1="DELETE FROM att_indirizzi WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      

    // att_map
    $sql1="DELETE FROM att_map WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    
    // att_ragsoc
    $sql1="DELETE FROM att_ragsoc WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      

    // att_clienti
    $sql1="DELETE FROM att_clienti WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      

    // att_scad
    $sql1="DELETE FROM att_scad WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      

    // attivita
    $sql1="DELETE FROM attivita WHERE idAttivita='".$id."'";
    $query1=mysqli_query($conn,$sql1);      
    
    print "ATTIVITA' RIMOSSA.<br /><br />";
}


print "<h4>ELIMINA CLIENTI (solo se oscurati e/o scaduti)</h4>";
$oggi=date("Ymd");
$totEli=0; $totAtt=0;
	 $sql="SELECT attivita.idAttivita,attivita,osc,dataScad 
     FROM attivita,att_scad 
     WHERE attivita.idAttivita=att_scad.idAttivita
     ORDER BY attivita.attivita ASC, osc ASC, dataScad ASC";
     	 
	 $query=mysqli_query($conn,$sql);
	 while ($row=mysqli_fetch_array($query,MYSQLI_ASSOC)){	 
     $totAtt++;
	   if ($oggi>$row['dataScad'] | $row['osc']=="s") {
       
       print "<form id='elimina_".$row['idAttivita']."' action='?id=".$row['idAttivita']."' method='post'>";
       print "<input type='text' size='5' name='nome' value='".$row['idAttivita']." ' disabled /> ";    
       $nomeAttivita=$myobj->mb_convert_encoding($row['attivita']);
       print "<input type='text' size='30' name='nome' value='".$nomeAttivita." ' disabled /> ";       
       print "<a href='cliente.php?id=".$row['idAttivita']."'><input type='button' name='modifica' value='MODIFICA'/></a> ";
       print "<input type='submit' name='submit' value='ELIMINA' />";       
       print "</form>";       
       
	       $totEli++;	       
        }	          
	 }

    print "<br /><br />Totale eliminabili: ".$totEli." su ".$totAtt." attivita' clienti.";
    
?>
<br /><br />
