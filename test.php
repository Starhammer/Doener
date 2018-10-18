<?php
session_start();
if(isset($_SESSION['token'])){
	//echo $_SESSION['token'];
}else{
	$_SESSION['token']="null";
}
?>
<meta http-equiv="refresh" content="0; URL=index.php">