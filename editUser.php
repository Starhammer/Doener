<?php
session_start();
include_once 'head.php';

$role = mysqli_fetch_row(query("SELECT Rolle FROM kunden WHERE kdnr='".$_SESSION['user']."'"))[0];
if($role != 'admin') header('Location: '.$base."\index.php");


$username = strtolower ($_POST['username']);
$email = $_POST['email'];
$vorname = $_POST['vorname'];
$nachname = $_POST['nachname'];
$kurs = $_POST['kurs'];
$rolle = $_POST['rolle'];
$val = $_POST['val'];

$kdnr = $_GET['kdnr'];
if(isset($kdnr)&&!empty($kdnr)){
	$kdnr = mysqli_real_escape_string($link,$kdnr);
	if(	isset($username)&&!empty($username)&&
		isset($email)&&!empty($email)&&
		isset($vorname)&&!empty($vorname)&&
		isset($nachname)&&!empty($nachname)&&
		isset($kurs)&&!empty($kurs)&&
		isset($rolle)&&!empty($rolle)){
		query("UPDATE kunden SET val='".$val."',name='".$nachname."',vorname='".$vorname."',kurs='".$kurs."',nick='".$username."',email='".$email."',Rolle='".$rolle."' WHERE kdnr='".$kdnr."'");
	}
	$user = mysqli_fetch_array(query("SELECT * From kunden WHERE kdnr='".$kdnr."'"));
	
}else{
?><meta http-equiv="refresh" content="0; URL=editUsers.php"><?php
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']."?kdnr=".$kdnr; ?>" method="Post" class="form-signin">
		<h1 class="h1 mb-3 font-weight-normal">Login</h1>
		Benutzername:
		<input class="form-control" id="username" name="username" type="text" placeholder="Benutzername" value="<?php echo $user['nick']?>" required>
		EMail(nur DHBW mails):
		<input class="form-control" id="email" name="email" type="text" placeholder="EMail" value="<?php echo $user['email']?>" required>
		Vorname:
		<input class="form-control" id="vorname" name="vorname" type="text" placeholder="Vorname" value="<?php echo $user['vorname']?>" required>
		Nachname:
		<input class="form-control" id="nachname" name="nachname" type="text" placeholder="Nachname" value="<?php echo $user['name']?>" required>
		Kurs:
		<input class="form-control" id="kurs" name="kurs" type="text" placeholder="Kurs" value="<?php echo $user['kurs']?>" required>
		Rolle:
		<input class="form-control" id="rolle" name="rolle" type="text" placeholder="Rolle" value="<?php echo $user['Rolle']?>" required>
		Valid:
		<input class="form-control" id="val" name="val" type="text" placeholder="Valid?" value="<?php echo $user['val']?>" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">speichern</button>
		 <a class="btn btn-lg btn-primary btn-block" href="editUsers.php">&Uuml;bersicht</a>
</form>


<?php
include_once "footer.php";
?>