<?php 
include_once 'connector.php';
$base = dirname($_SERVER['PHP_SELF']);
session_start();

function checkSession(){
    global $base;
    if(isset($_SESSION['token'])&&isset($_SESSION['user'])){
         $sessions = query("SELECT * FROM sessions");
         $valid = false;
       
         while($session = mysqli_fetch_array($sessions)){
             if($_SESSION['token']==$session['Sessionnr']&&$_SESSION['user']==$session['name'])$valid= true;
         }
        if(!$valid)
		{
			?>
			<meta http-equiv="refresh" content="0; URL=./index.php">
			<?php		
		}       
    }
	else
	{
		?>
		<meta http-equiv="refresh" content="0; URL=./index.php">
		<?php
    }
    
}

?>