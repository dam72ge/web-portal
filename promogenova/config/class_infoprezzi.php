<?php
// FUNZIONI DATABASE 

class mysql extends pagina{

  function infoprezzi($conn,$where){    
    $dati=array(
	"id" => array (""),
	"proposta" => array (""),
	"tipo" => array (""),
	"sottotipo" => array (""),
	"destinatari" => array (""),
	"descrizione" => array (""),
	"durata" => array (""),
	"costo" => array (""),
	"scontoclienti" => array (""),
	"esempio" => array ("")
    );
    $sql="
    SELECT id,proposta,tipo,sottotipo,destinatari,descrizione,durata,costo,scontoclienti,esempio
    FROM infoprezzi
    ".$where." 
    ORDER BY id ASC";    
    $query=mysqli_query($conn,$sql);			
    while ($riga=mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $dati['id'][]=$riga['id'];
        $dati['proposta'][]=$riga['proposta'];
        $dati['tipo'][]=$riga['tipo'];
        $dati['sottotipo'][]=$riga['sottotipo'];
        $dati['destinatari'][]=$riga['destinatari'];
        $dati['descrizione'][]=$riga['descrizione'];
        $dati['durata'][]=$riga['durata'];
        $dati['costo'][]=$riga['costo'];
        $dati['scontoclienti'][]=$riga['scontoclienti'];
        $dati['esempio'][]=$riga['esempio'];
    }
    return $dati;
  }

// estrai e visualizza proposte
  function proposte($infoprezzi,$tipo,$sfondotitolo){
    for ($i=0;$i<count($infoprezzi['id']);$i++) {
        if ($infoprezzi['tipo'][$i]==$tipo) {
            $txtConv=$this->mb_convert_encoding($infoprezzi['proposta'][$i]);
            print "<h4 class='bianco sfTondo ".$sfondotitolo."'>".$txtConv."</h4>";
            print "<p class='testo'>";
            if ($infoprezzi['sottotipo'][$i]!="") {
            $txtConv=$this->mb_convert_encoding($infoprezzi['sottotipo'][$i]);
                print "<span class='verde'>".$txtConv."</span><br />";
            }
            $txtConv=$this->mb_convert_encoding($infoprezzi['destinatari'][$i]);
            print "<b>A chi si rivolge</b>: ".$txtConv."<br />";
            $estratto=substr($infoprezzi['descrizione'][$i],0,150); 
            if (strlen($infoprezzi['descrizione'][$i])>strlen($estratto)) { $estratto.="... [continua]"; }
            $estratto.="</b></i></a></span>"; 
            $txtConv=$this->mb_convert_encoding($estratto);
            print "<b>In cosa consiste</b>: ".nl2br($txtConv)."<br />";
            if ($infoprezzi['costo'][$i]!="") {
            $txtConv=$this->mb_convert_encoding($infoprezzi['costo'][$i]);
                print "<b>Costo</b>: ".$txtConv."<br />";
            }
            if ($infoprezzi['scontoclienti'][$i]!="") {
            $txtConv=$this->mb_convert_encoding($infoprezzi['scontoclienti'][$i]);
                print "<b>Sconti e agevolazioni</b>: ".$txtConv."<br />";
            }
            
            print "<a href='proposta.php?id=".$infoprezzi['id'][$i]."'><img src='../lay/freccia.gif' alt='[clicca]' /> Clicca QUI per visualizzare tutta la proposta</a><br />";
            print "<br /></p>";
        }	
    }    
  }
    

}  // chiude la classe
?>
