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
       $t=str_replace("�", " ", $t);
       $t=str_replace("�", " ", $t);
       $t=str_replace("�", "'", $t);
       $t=str_replace("�", "a", $t);
       $t=str_replace("�", "a", $t);
       $t=str_replace("�", "e", $t);
       $t=str_replace("�", "e", $t);
       $t=str_replace("�", "i", $t);
       $t=str_replace("�", "o", $t);
       $t=str_replace("�", "u", $t);
       $t=str_replace("�", "A", $t);
       $t=str_replace("�", "a", $t);
       $t=str_replace("|", "", $t);
       $t=str_replace("�", "", $t);
       $t=str_replace("$", "", $t);
       $t=str_replace("%", "", $t);
       $t=str_replace("&", "", $t);
       $t=str_replace("*", "", $t);
       $t=str_replace("�", "c", $t);
       $t=str_replace("@", " ", $t);
       $t=str_replace("�", "", $t);
       $t=str_replace("#", "", $t);
       $t=str_replace("�", "", $t);
       
$t=str_replace("^"," ", $t);
$t=str_replace("`","'", $t);
$t=str_replace("{"," ", $t);
$t=str_replace("|"," ", $t);
$t=str_replace("}"," ", $t);
$t=str_replace("~"," ", $t);
$t=str_replace(""," ", $t);
$t=str_replace("�"," EUR ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","...", $t);
$t=str_replace("�","+", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","S", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","OE", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","Z", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","'", $t);
$t=str_replace("�","'", $t);
$t=str_replace("�","''", $t);
$t=str_replace("�","''", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","-", $t);
$t=str_replace("�","-", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","s", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","oe", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","z", $t);
$t=str_replace("�","Y", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","-", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","2", $t);
$t=str_replace("�","3", $t);
$t=str_replace("�","'", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","1", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","A", $t);
$t=str_replace("�","A", $t);
$t=str_replace("�","A", $t);
$t=str_replace("�","A", $t);
$t=str_replace("�","A", $t);
$t=str_replace("�","A", $t);
$t=str_replace("�","AE", $t);
$t=str_replace("�","C", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","E", $t);
$t=str_replace("�","E", $t);
$t=str_replace("�","E", $t);
$t=str_replace("�","I", $t);
$t=str_replace("�","I", $t);
$t=str_replace("�","I", $t);
$t=str_replace("�","I", $t);
$t=str_replace("�","D", $t);
$t=str_replace("�","N", $t);
$t=str_replace("�","O", $t);
$t=str_replace("�","O", $t);
$t=str_replace("�","O", $t);
$t=str_replace("�","O", $t);
$t=str_replace("�","O", $t);
$t=str_replace("�","x", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","U", $t);
$t=str_replace("�","U", $t);
$t=str_replace("�","U", $t);
$t=str_replace("�","U", $t);
$t=str_replace("�","Y", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","B", $t);
$t=str_replace("�","a", $t);
$t=str_replace("�","a", $t);
$t=str_replace("�","a", $t);
$t=str_replace("�","a", $t);
$t=str_replace("�","a", $t);
$t=str_replace("�","a", $t);
$t=str_replace("�","ae", $t);
$t=str_replace("�","c", $t);
$t=str_replace("�","e", $t);
$t=str_replace("�","e", $t);
$t=str_replace("�","e", $t);
$t=str_replace("�","e", $t);
$t=str_replace("�","i", $t);
$t=str_replace("�","i", $t);
$t=str_replace("�","i", $t);
$t=str_replace("�","i", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","n", $t);
$t=str_replace("�","o", $t);
$t=str_replace("�","o", $t);
$t=str_replace("�","o", $t);
$t=str_replace("�","o", $t);
$t=str_replace("�","o", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","u", $t);
$t=str_replace("�","u", $t);
$t=str_replace("�","u", $t);
$t=str_replace("�","u", $t);
$t=str_replace("�","y", $t);
$t=str_replace("�"," ", $t);
$t=str_replace("�","y", $t);

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
