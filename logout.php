<?php
include_once 'head.php';
//session_start();
debug_to_console("Session destroyed: ".var_export(session_destroy(),true));
//$_SESSION = array();
 
echo "Logout erfolgreich, Sie werden in 5 Sekunden zum Login umgeleitet";

header( "refresh:5;url=".$base."\index.php" );
?>
<?php require_once 'footer.php';?>