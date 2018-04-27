<?php
$tipoSess=$_SESSION['tipoSess'];
$timeAccesso=$_SESSION['timeAccesso'];


// leggi variabili sessione - per amministrare vetrine nell'area clienti
if (isset($_SESSION['cartella'])){

$attivita=$_SESSION['attivita'];
$idAttivita=$_SESSION['idAttivita'];
$utente=$_SESSION['utente'];
$pwd=$_SESSION['pwd'];
$cartella=$_SESSION['cartella'];
$logo=$_SESSION['logo'];
$dataReg=$_SESSION['dataReg']; // registrazione attività
$dataScad=$_SESSION['dataScad']; // scadenza contratto
$dataAvv=$_SESSION['dataAvv']; // avviso scadenza contratto (2 settimane prima)
$dataOsc=$_SESSION['dataOsc']; // oscuramento definitivo (1 mese dopo scadenza contratto)


// opz vetrina
$vetrOmaggio=$_SESSION['vetrOmaggio']; 
$creaEventi=$_SESSION['creaEventi']; 
$assistPeriod=$_SESSION['assistPeriod']; 
$creaPromo=$_SESSION['creaPromo']; 

// dati ad uso interno
$clienteTel=$_SESSION['clienteTel']; 
$clienteEmail=$_SESSION['clienteEmail']; 
$clienteNota=$_SESSION['clienteNota']; 

// mappa
$mappa=$_SESSION['mappa']; 

// indirizzo
$indirizzo=$_SESSION['indirizzo']; 
$nciv=$_SESSION['nciv']; 
$cap=$_SESSION['cap']; 

$idR=$_SESSION['idR']; 
$regione=$_SESSION['regione']; 
$idP=$_SESSION['idP']; 
$provincia=$_SESSION['provincia']; 
$sigla=$_SESSION['sigla']; 
$idC=$_SESSION['idC']; 
$comune=$_SESSION['comune']; 
$idM=$_SESSION['idM']; 
$municipio=$_SESSION['municipio']; 
$idQ=$_SESSION['idQ']; 
$quartiere=$_SESSION['quartiere']; 
$altraZona=$_SESSION['altraZona']; 

// rag soc, p iva, cf
$ragsoc=$_SESSION['ragsoc']; 
$partitaiva=$_SESSION['partitaiva']; 
$codfisc=$_SESSION['codfisc']; 

// testi vetrina: chisiamo e orari
$chisiamo=$_SESSION['chisiamo']; 
$orari=$_SESSION['orari']; 

// variabili nuovi articoli
$art_id=$_SESSION['art_id'];
$art_osc=$_SESSION['art_osc'];
$art_img=$_SESSION['art_img'];
$art_titolo=$_SESSION['art_titolo'];
$art_testo=$_SESSION['art_testo'];
$art_idMacro=$_SESSION['art_idMacro'];
$art_macro=$_SESSION['art_macro'];
$art_dataReg=$_SESSION['art_dataReg'];

// variabili per creaPromo='s' 
$art_promozione=$_SESSION['art_promozione'];
$art_idR=$_SESSION['art_idR']; 
$art_idP=$_SESSION['art_idP']; 
$art_idC=$_SESSION['art_idC']; 
$art_idM=$_SESSION['art_idM']; 
$art_idQ=$_SESSION['art_idQ']; 

// variabili per creaEventi='s' 
$ev_id=$_SESSION['ev_id'];
$ev_titolo=$_SESSION['ev_titolo'];
$ev_testo=$_SESSION['ev_testo'];

$ev_anno=$_SESSION['ev_anno'];
$ev_dataInizio=$_SESSION['ev_dataInizio'];
$ev_oreInizio=$_SESSION['ev_oreInizio'];
$ev_dataFine=$_SESSION['ev_dataFine'];
$ev_oreFine=$_SESSION['ev_oreFine'];
$ev_dataAvv=$_SESSION['ev_dataAvv'];
$ev_dataOsc=$_SESSION['ev_dataOsc'];

$ev_img=$_SESSION['ev_img'];
$ev_idR=$_SESSION['ev_idR']; 
$ev_idP=$_SESSION['ev_idP']; 
$ev_idC=$_SESSION['ev_idC']; 
$ev_idM=$_SESSION['ev_idM']; 
$ev_idQ=$_SESSION['ev_idQ']; 
$ev_luogo=$_SESSION['ev_luogo'];

}
?>
