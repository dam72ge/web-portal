<?php
$_SESSION['timeAccesso']=$timeAccesso;
$_SESSION['tipoSess']=$tipoSess;


// variabili sessione - per amministrare vetrine nell'area clienti
if (isset($pwd)){
$_SESSION['attivita']=$attivita;
$_SESSION['idAttivita']=$idAttivita;
$_SESSION['utente']=$utente; // nome
$_SESSION['pwd']=$pwd; // nome
$_SESSION['cartella']=$cartella;
$_SESSION['logo']=$logo;
$_SESSION['dataReg']=$dataReg; // registrazione attività
$_SESSION['dataScad']=$dataScad; // scadenza
$_SESSION['dataAvv']=$dataAvv; // avviso scadenza (2 settimane prima)
$_SESSION['dataOsc']=$dataOsc; // oscuramento definitivo (1 mese dopo scadenza)

// opz vetrina
$_SESSION['vetrOmaggio']=$vetrOmaggio; 
$_SESSION['creaEventi']=$creaEventi; 
$_SESSION['assistPeriod']=$assistPeriod; 
$_SESSION['creaPromo']=$creaPromo; 

// dati ad uso interno
$_SESSION['clienteTel']=$clienteTel; 
$_SESSION['clienteEmail']=$clienteEmail; 
$_SESSION['clienteNota']=$clienteNota; 

// mappa
$_SESSION['mappa']=$mappa; 

// indirizzo
$_SESSION['indirizzo']=$indirizzo; 
$_SESSION['nciv']=$nciv; 
$_SESSION['cap']=$cap; 

$_SESSION['idR']=$idR; 
$_SESSION['regione']=$regione; 
$_SESSION['idP']=$idP; 
$_SESSION['provincia']=$provincia; 
$_SESSION['sigla']=$sigla; 
$_SESSION['idC']=$idC; 
$_SESSION['comune']=$comune; 
$_SESSION['idM']=$idM; 
$_SESSION['municipio']=$municipio; 
$_SESSION['idQ']=$idQ; 
$_SESSION['quartiere']=$quartiere; 
$_SESSION['altraZona']=$altraZona; 

// rag soc, p iva, cf
$_SESSION['ragsoc']=$ragsoc; 
$_SESSION['partitaiva']=$partitaiva; 
$_SESSION['codfisc']=$codfisc; 

// testi vetrina: chisiamo e orari
$_SESSION['chisiamo']=$chisiamo; 
$_SESSION['orari']=$orari; 

// variabili nuovi articoli
$_SESSION['art_id']=0;
$_SESSION['art_osc']="s";
$_SESSION['art_img']="";
$_SESSION['art_titolo']="";
$_SESSION['art_testo']="";
$_SESSION['art_idMacro']="";
$_SESSION['art_macro']="";
$_SESSION['art_dataReg']="";

// variabili per creaPromo='s' 
$_SESSION['art_promozione']="n";
$_SESSION['art_idR']=$idR; 
$_SESSION['art_idP']=$idP; 
$_SESSION['art_idC']=$idC; 
$_SESSION['art_idM']=$idM; 
$_SESSION['art_idQ']=$idQ; 

// variabili per creaEventi='s' 
$_SESSION['ev_id']=0;
$_SESSION['ev_titolo']="";
$_SESSION['ev_testo']="";

$_SESSION['ev_anno']=0;
$_SESSION['ev_dataInizio']="";
$_SESSION['ev_oreInizio']="";
$_SESSION['ev_dataFine']="";
$_SESSION['ev_oreFine']="";
$_SESSION['ev_dataAvv']="";
$_SESSION['ev_dataOsc']="";

$_SESSION['ev_img']="";
$_SESSION['ev_idR']=$idR; 
$_SESSION['ev_idP']=$idP; 
$_SESSION['ev_idC']=$idC; 
$_SESSION['ev_idM']=$idM; 
$_SESSION['ev_idQ']=$idQ; 
$_SESSION['ev_luogo']="";
}
?>
