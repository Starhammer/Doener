<?php 
session_start();
require_once 'head.php';

$role = mysqli_fetch_row(query("SELECT Rolle FROM kunden WHERE kdnr='".$_SESSION['user']."'"))[0];
if($role != 'admin') header('Location: '.$base."\index.php");

$auftragsnummer = $_GET['aufnr'];
$aufpos = mysqli_fetch_array(query("SELECT * FROM aufpos WHERE aufnr='".$auftragsnummer."'"))['posnr'];

$zutaten = query("SELECT * FROM zutbest WHERE posnr='".$aufpos."'");

while($zutat = mysqli_fetch_array($zutaten)['zbnr']){
	query("DELETE FROM `zutbest` WHERE `zutbest`.`zbnr` = ".$zutat);
}

query("DELETE FROM `aufpos` WHERE `posnr` = ".$aufpos);

query("DELETE FROM `auftrag` WHERE `aufnr` = ".$auftragsnummer);

?>
<meta http-equiv="refresh" content="0; URL=zeigeAlleBestellungen.php">