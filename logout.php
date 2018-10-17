<?php
session_start();
include_once 'head.php';
debug_to_console("Session destroyed: ".var_export(session_destroy(),true));

 
echo "Logout erfolgreich, Sie werden in 5 Sekunden zum Login umgeleitet";


?>
<meta http-equiv="refresh" content="5; URL=index.php">
<?php require_once 'footer.php';?>