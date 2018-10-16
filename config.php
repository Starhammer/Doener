<?php

include_once 'connector.php';

session_start();

if (strpos($_SERVER['SCRIPT_NAME'], 'index') == false) {
	checkSession();
}

ini_set('display_errors',0);
error_reporting(E_NOTICE);
$base = dirname($_SERVER['PHP_SELF']);

function checkSession(){
	debug_to_console("checking Session");
    global $base;
	
    if(isset($_SESSION['token'])&&isset($_SESSION['user'])){
         $sessions = query("SELECT * FROM sessions");
         $valid = false;
       
         while($session = mysqli_fetch_array($sessions)){
             if($_SESSION['token']==$session['Sessionnr']&&$_SESSION['user']==$session['name'])
			 {
				$valid= true;
				debug_to_console("Session valid");
			 }
         }
        if(!$valid)
		{
			debug_to_console("Session invalid");
			?>
			<meta http-equiv="refresh" content="0; URL=index.php">
			<?php		
		}       
    }
	else
	{
		debug_to_console("Session not found");
		?>
		<meta http-equiv="refresh" content="0; URL=index.php">
		<?php
    }
    
}

function debug_to_console( $data ) {
    $output = $data;
    echo "<script>console.log( '". $output ."' );</script>";
}

?>