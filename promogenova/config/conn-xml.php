<?php
// connetti al db
$inc=$url."config/mydb.php";
include $inc;

// carica elenchi

$inc=$url."config/class_layout.php"; require_once $inc; $myobj=new pagina;
$inc=$url."config/class_db.php"; require_once $inc; $db=new db;

// baselink
$baseLink="http://www.promogenova.it";

// data oggi
$oggi=date("Ymd");

// funzione pubDate - in formato rfc822 ( Sat, 07 Sep 2002 09:42:31 GMT )
function pubDate($x){
   $mm['01']="Jan"; $mm['02']="Feb"; $mm['03']="Mar";
   $mm['04']="Apr"; $mm['05']="May"; $mm['06']="Jun";
   $mm['07']="Jul"; $mm['08']="Aug"; $mm['09']="Sep";
   $mm['10']="Oct"; $mm['11']="Nov"; $mm['12']="Dec";
   $mese=substr($x,4,2);
   $y=substr($x,6,2)." ".$mm[$mese]." ".substr($x,0,4);
$d=" ".$y." 00:00:00 GMT";
return $d;
}

// funzione sostituisci ora in data pubDate ( ...00:00:00 --> ...12:27:42 +0000</pubDate>)
function sostOre($x,$ore){
$ore.=":00";
$d=str_replace("00:00:00",$ore,$x);
return $d;
}

// funzione ripulisci nomi titoli ecc
function ripulisci($t){
	$t=strtolower($t);
       $t=str_replace("'", " ", $t);
       $virg=chr(34);
       $t=str_replace($virg, " ", $t);
       $t=str_replace("&", "e", $t);
       $t=str_replace("!", " ", $t);
       $t=str_replace("?", " ", $t);
       $t=str_replace(".", " ", $t);
       $t=str_replace(";", " ", $t);
       $t=str_replace("(", " ", $t);
       $t=str_replace(")", " ", $t);
       $t=str_replace(",", " ", $t);
       $t=str_replace(":", " ", $t);
       $t=str_replace("«", " ", $t);
       $t=str_replace("»", " ", $t);
       $t=str_replace("’", "'", $t);
       $t=str_replace("ä", "a", $t);
       $t=str_replace("à", "a", $t);
       $t=str_replace("è", "e", $t);
       $t=str_replace("é", "e", $t);
       $t=str_replace("ì", "i", $t);
       $t=str_replace("ò", "o", $t);
       $t=str_replace("ù", "u", $t);
       $t=str_replace("Â", "A", $t);
       $t=str_replace("â", "a", $t);
       $t=str_replace("|", "", $t);
       $t=str_replace("£", "", $t);
       $t=str_replace("$", "", $t);
       $t=str_replace("%", "", $t);
       $t=str_replace("&", "", $t);
       $t=str_replace("*", "", $t);
       $t=str_replace("ç", "c", $t);
       $t=str_replace("@", " ", $t);
       $t=str_replace("°", "", $t);
       $t=str_replace("#", "", $t);
       $t=str_replace("§", "", $t);
       
$t=str_replace("^"," ", $t);
$t=str_replace("`","'", $t);
$t=str_replace("{"," ", $t);
$t=str_replace("|"," ", $t);
$t=str_replace("}"," ", $t);
$t=str_replace("~"," ", $t);
$t=str_replace(""," ", $t);
$t=str_replace("€"," EUR ", $t);
$t=str_replace(""," ", $t);
$t=str_replace("ƒ"," ", $t);
$t=str_replace("„"," ", $t);
$t=str_replace("…","...", $t);
$t=str_replace("†","+", $t);
$t=str_replace("‡"," ", $t);
$t=str_replace("ˆ"," ", $t);
$t=str_replace("‰"," ", $t);
$t=str_replace("Š","S", $t);
$t=str_replace("‹"," ", $t);
$t=str_replace("Œ","OE", $t);
$t=str_replace(""," ", $t);
$t=str_replace("Ž","Z", $t);
$t=str_replace(""," ", $t);
$t=str_replace(""," ", $t);
$t=str_replace("‘","'", $t);
$t=str_replace("’","'", $t);
$t=str_replace("“","''", $t);
$t=str_replace("”","''", $t);
$t=str_replace("•"," ", $t);
$t=str_replace("–","-", $t);
$t=str_replace("—","-", $t);
$t=str_replace("˜"," ", $t);
$t=str_replace("™"," ", $t);
$t=str_replace("š","s", $t);
$t=str_replace("›"," ", $t);
$t=str_replace("œ","oe", $t);
$t=str_replace(""," ", $t);
$t=str_replace("ž","z", $t);
$t=str_replace("Ÿ","Y", $t);
$t=str_replace("¡"," ", $t);
$t=str_replace("¢"," ", $t);
$t=str_replace("£"," ", $t);
$t=str_replace("¤"," ", $t);
$t=str_replace("¥"," ", $t);
$t=str_replace("¦"," ", $t);
$t=str_replace("§"," ", $t);
$t=str_replace("¨"," ", $t);
$t=str_replace("©"," ", $t);
$t=str_replace("ª"," ", $t);
$t=str_replace("«"," ", $t);
$t=str_replace("¬"," ", $t);
$t=str_replace("­","-", $t);
$t=str_replace("®"," ", $t);
$t=str_replace("¯"," ", $t);
$t=str_replace("°"," ", $t);
$t=str_replace("±"," ", $t);
$t=str_replace("²","2", $t);
$t=str_replace("³","3", $t);
$t=str_replace("´","'", $t);
$t=str_replace("µ"," ", $t);
$t=str_replace("¶"," ", $t);
$t=str_replace("·"," ", $t);
$t=str_replace("¸"," ", $t);
$t=str_replace("¹","1", $t);
$t=str_replace("º"," ", $t);
$t=str_replace("»"," ", $t);
$t=str_replace("¼"," ", $t);
$t=str_replace("½"," ", $t);
$t=str_replace("¾"," ", $t);
$t=str_replace("¿"," ", $t);
$t=str_replace("À","A", $t);
$t=str_replace("Á","A", $t);
$t=str_replace("Â","A", $t);
$t=str_replace("Ã","A", $t);
$t=str_replace("Ä","A", $t);
$t=str_replace("Å","A", $t);
$t=str_replace("Æ","AE", $t);
$t=str_replace("Ç","C", $t);
$t=str_replace("È"," ", $t);
$t=str_replace("É","E", $t);
$t=str_replace("Ê","E", $t);
$t=str_replace("Ë","E", $t);
$t=str_replace("Ì","I", $t);
$t=str_replace("Í","I", $t);
$t=str_replace("Î","I", $t);
$t=str_replace("Ï","I", $t);
$t=str_replace("Ð","D", $t);
$t=str_replace("Ñ","N", $t);
$t=str_replace("Ò","O", $t);
$t=str_replace("Ó","O", $t);
$t=str_replace("Ô","O", $t);
$t=str_replace("Õ","O", $t);
$t=str_replace("Ö","O", $t);
$t=str_replace("×","x", $t);
$t=str_replace("Ø"," ", $t);
$t=str_replace("Ù","U", $t);
$t=str_replace("Ú","U", $t);
$t=str_replace("Û","U", $t);
$t=str_replace("Ü","U", $t);
$t=str_replace("Ý","Y", $t);
$t=str_replace("Þ"," ", $t);
$t=str_replace("ß","B", $t);
$t=str_replace("à","a", $t);
$t=str_replace("á","a", $t);
$t=str_replace("â","a", $t);
$t=str_replace("ã","a", $t);
$t=str_replace("ä","a", $t);
$t=str_replace("å","a", $t);
$t=str_replace("æ","ae", $t);
$t=str_replace("ç","c", $t);
$t=str_replace("è","e", $t);
$t=str_replace("é","e", $t);
$t=str_replace("ê","e", $t);
$t=str_replace("ë","e", $t);
$t=str_replace("ì","i", $t);
$t=str_replace("í","i", $t);
$t=str_replace("î","i", $t);
$t=str_replace("ï","i", $t);
$t=str_replace("ð"," ", $t);
$t=str_replace("ñ","n", $t);
$t=str_replace("ò","o", $t);
$t=str_replace("ó","o", $t);
$t=str_replace("ô","o", $t);
$t=str_replace("õ","o", $t);
$t=str_replace("ö","o", $t);
$t=str_replace("÷"," ", $t);
$t=str_replace("ø"," ", $t);
$t=str_replace("ù","u", $t);
$t=str_replace("ú","u", $t);
$t=str_replace("û","u", $t);
$t=str_replace("ü","u", $t);
$t=str_replace("ý","y", $t);
$t=str_replace("þ"," ", $t);
$t=str_replace("ÿ","y", $t);

    $t=htmlentities(stripslashes($t));

       $t=str_replace("&agrave;", "a", $t);
       $t=str_replace("&egrave;", "e", $t);
       $t=str_replace("&eacute;", "e", $t);
       $t=str_replace("&igrave;", "i", $t); 
       $t=str_replace("&ograve;", "o", $t);
       $t=str_replace("&ugrave;", "u", $t);
       $t=str_replace("&atilde;", "", $t);
       $t=str_replace("&not;", "", $t);

	return $t;
}

?>
