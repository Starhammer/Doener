<?php require_once 'head.php';
checkSession();

$old_pw = hash("sha1",$_POST['old_pw']);
$new_pw = $_POST['new_pw'];
$new_confirmed_pw = hash("sha1",$_POST['new_confirmed_pw']);

if(strlen($new_pw)<4){
    $msg= "Password muss mindestens 4 Zeichen lang sein";
}else{
    $new_pw = hash("sha1",$new_pw);
    $kunde = mysqli_fetch_array(query("SELECT pw FROM kunden WHERE kdnr='".$_SESSION['user']."'"));
    if($kunde[0]==$old_pw){
        if($new_pw==$new_confirmed_pw){
            query("Update kunden SET pw = '".$new_pw."' WHERE kdnr='".$_SESSION['user']."'");
            $msg= "Passwort wurde ge&auml;ndert";
        }
    }
}
?>
<body>
<header>
	<h1>Passwort &auml;ndern</h1>
</header>
<nav style="padding-top:3%">
	<a href="<?php echo $base."/kundenkonto.php";?>">Zur&uuml;ck zum Kundenkonto</a>
</nav>
<div id="main">
		<p><?php echo  $msg;?></p>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
			<table style=" border: none">
			<tr><td>Aktuelles Passwort:</td><td><input type="password" id="old_pw" name="old_pw" type="text"></td></tr>
    		<tr><td>Neues Passwort:</td><td><input  type="password" id="new_pw" name="new_pw" type="text"></td></tr>
    		<tr><td>Neues Passwort best&auml;tigen:</td><td><input  type="password" id="new_confirmed_pw" name="new_confirmed_pw" type="text"></td></tr>
			</table>
			<button type="submit" style="margin-top:1em">Passwort &auml;ndern</button>
    	</form>
	</div>
</body>


<?php require_once 'footer.php';?>