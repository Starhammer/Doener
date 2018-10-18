<?php
include_once 'head.php';

$username = strtolower ($_POST['username']);
$passwort = $_POST['passwort'];
$passwortBestaetigt = hash("sha1",$_POST['passwortBe']);
$email = $_POST['email'];
$vorname = $_POST['vorname'];
$nachname = $_POST['nachname'];
$kurs = $_POST['kurs'];

if(	isset($username)&&!empty($username)&&
	isset($passwort)&&!empty($passwort)&&
	isset($passwortBestaetigt)&&!empty($passwortBestaetigt)&&
	isset($email)&&!empty($email)&&
	isset($vorname)&&!empty($vorname)&&
	isset($nachname)&&!empty($nachname)&&
	isset($kurs)&&!empty($kurs)){
	
	if(mysqli_num_rows(query("Select * FROM kunden WHERE nick='".$username."'"))==0){
		if(strlen($passwort)>=4){
			if($passwortBestaetigt==hash("sha1",$passwort)){
				if(strpos($email,"@lehre.mosbach.dhbw.de")!==false){
					if(mysqli_num_rows(query("Select * FROM kunden WHERE email='".$email."'"))==0){
						$kdnr = trim(mysqli_fetch_array(query("SELECT * FROM `kunden` ORDER BY `kunden`.`kdnr` DESC LIMIT 1"))['kdnr'])+1;
						query("INSERT INTO kunden (kdnr, 			name,		vorname,	  val,    kurs,		    nick,		    	pw,				email, konto,rolle)
										   Values ('".$kdnr."','".$nachname."','".$vorname."','N','".$kurs."','".$username."','".$passwortBestaetigt."','".$email."','0.0','user')");
						echo "Erfolgreich registriert, ihr Konto wird von einem Admin geprüft und dann freigegeben, bei einer Freigabe bekommst du eine Mail";
					}else{
						echo "Mail-Adresse wird bereits verwendet, wenden dich an einen Admin";
					}
				}else{
					echo "Bitte eine valide DHBW Mail-Adresse eingeben";
				}
			}else{
				echo "Passwort stimmt nicht überein";
			}
		}else{
			echo "Passwort ist zu kurz";
		}
	}else{
		echo "Username wird bereits verwendet";
	}
}

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" class="form-signin">
		<h1 class="h1 mb-3 font-weight-normal">Login</h1>
		<label class="sr-only" for="username">Benutzername:</label>
		<input class="form-control" id="username" name="username" type="text" placeholder="Benutzername" required>
		<label class="sr-only" for="passwort">Passwort:</label>
		<input class="form-control" id="passwort" name="passwort" type="password" placeholder="Passwort" required>
		<label class="sr-only" for="passwortBe">Passwort best&auml;tigen:</label>
		<input class="form-control" id="passwort" name="passwortBe" type="password" placeholder="Passwort bestätigen" required>
		<label class="sr-only" for="email">EMail(nur DHBW mails):</label>
		<input class="form-control" id="email" name="email" type="text" placeholder="EMail" required>
		<label class="sr-only" for="vorname">Vorname:</label>
		<input class="form-control" id="vorname" name="vorname" type="text" placeholder="Vorname" required>
		<label class="sr-only" for="nachname">Nachname:</label>
		<input class="form-control" id="nachname" name="nachname" type="text" placeholder="Nachname" required>
		<label class="sr-only" for="kurs">Kurs:</label>
		<input class="form-control" id="kurs" name="kurs" type="text" placeholder="Kurs" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Registrieren</button>
</form>

<?php 
//import std Footer
require_once 'footer.php';
?>
