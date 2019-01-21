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
$passwort = hash("sha1",$_POST['passwort']);

$kdnr = $_GET['kdnr'];
if(isset($kdnr)&&!empty($kdnr)){
	$kdnr = mysqli_real_escape_string($link,$kdnr);
	if(	isset($username)&&!empty($username)&&
		isset($email)&&!empty($email)&&
		isset($vorname)&&!empty($vorname)&&
		isset($nachname)&&!empty($nachname)&&
		isset($kurs)&&!empty($kurs)&&
		isset($rolle)&&!empty($rolle))
	{
		if(isset($passwort))
		{
			query("UPDATE kunden SET val='".$val."',name='".$nachname."',vorname='".$vorname."',kurs='".$kurs."',nick='".$username."',email='".$email."',Rolle='".$rolle."',pw='".$passwort."' WHERE kdnr='".$kdnr."'");
		}
		else {
			query("UPDATE kunden SET val='".$val."',name='".$nachname."',vorname='".$vorname."',kurs='".$kurs."',nick='".$username."',email='".$email."',Rolle='".$rolle."' WHERE kdnr='".$kdnr."'");
		}
		
	}
	$user = mysqli_fetch_array(query("SELECT * From kunden WHERE kdnr='".$kdnr."'"));
	
}else{
?><meta http-equiv="refresh" content="0; URL=editUsers.php"><?php
}
?>
<header>
	<h1 class="h1 mb-3 font-weight-normal">Login</h1>
</header>
<div class="container">
	<form action="<?php echo $_SERVER['PHP_SELF']."?kdnr=".$kdnr; ?>" method="Post" class="form-signin edit">
		<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="username">Benutzername</label>
			<div class="col-sm-8">
				<input class="form-control" id="username" name="username" type="text" placeholder="Benutzername" value="<?php echo $user['nick']?>" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="email">EMail (nur DHBW mails):</label>
			<div class="col-sm-8">
				<input class="form-control" id="email" name="email" type="email" placeholder="EMail" value="<?php echo $user['email']?>" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="vorname">Vorname</label>
			<div class="col-sm-8">
				<input class="form-control" id="vorname" name="vorname" type="text" placeholder="Vorname" value="<?php echo $user['vorname']?>" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="nachname">Nachname</label>
			<div class="col-sm-8">
				<input class="form-control" id="nachname" name="nachname" type="text" placeholder="Nachname" value="<?php echo $user['name']?>" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="kurs">Kurs</label>
			<div class="col-sm-8">
				<input class="form-control" id="kurs" name="kurs" type="text" placeholder="Kurs" value="<?php echo $user['kurs']?>" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="rolle">Rolle</label>
			<div class="col-sm-8">
				<input class="form-control" id="rolle" name="rolle" type="text" placeholder="Rolle" value="<?php echo $user['Rolle']?>" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="val">Validiert</label>
			<div class="col-sm-8">
				<select class="form-control" id="val" name="val" value="<?php echo $user['val']?>" required>
					<option <?php if($user['val'] == 'J') echo selected;?> value="J">Ja</option>
					<option <?php if($user['val'] == 'N') echo selected;?> value="N">Nein</option>
				</select>
			</div>
		</div>		
		<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="passwort">neues Kennwort</label>
			<div class="col-sm-8">
				<input class="form-control" id="passwort" name="passwort" type="passwort" placeholder="">
			</div>
		</div>
		<button class="btn btn-primary btn-flex" type="submit">speichern</button>
		<a class="btn btn-primary btn-flex" href="editUsers.php">&Uuml;bersicht</a>
	</form>
</div>

<?php
include_once "footer.php";
?>