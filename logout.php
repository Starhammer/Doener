<?php
include_once 'config.php';
session_start();
session_destroy();
//$_SESSION = array();
 
echo "Logout erfolgreich, Sie werden in 5 Sekunden zum Login umgeleitet";

header( "refresh:5;url=".$base."\index.php" );
?>