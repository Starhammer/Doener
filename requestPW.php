<?php 
session_start();
require_once 'head.php';
require_once "lib/PHPMailer-5.2/PHPMailerAutoload.php";

$userMail = strtolower ($_POST['userMail']);


if(isset($userMail)&&!empty($userMail))
{
	$kdnr = null;
	$users = query("SELECT * FROM kunden");
	$valid = 0;
	 while ($user = mysqli_fetch_array($users)) {
        if($user['email']== $userMail & $user['val']=="J"){
			debug_to_console("User found in Database");
			$kdnr = $user['kdnr'];
			$valid = 1;			
			break;
        }
    }

	if($valid == 1){
		$newPasswort = randomPassword();
		sendMail($newPasswort, $userMail);
		savePasswort($newPasswort, $kdnr);
	}
	else{
		debug_to_console("User not found");
			echo "Die eingebene e-Mail ist falsch oder nicht registriert!";
	}
    mysqli_free_result($users);	
}

function savePasswort($pw, $kd)
{
	$passwort = hash("sha1",$pw);
	query("UPDATE kunden SET pw = '".$passwort."' WHERE kdnr = '".$kd."'");	
}

function sendMail($pw, $sendTo)
{
	$mail =new PHPMailer;
	$mail->isSMTP();
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;
	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';
	// use
	// $mail->Host = gethostbyname('smtp.gmail.com');
	// if your network does not support SMTP over IPv6
	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;
	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';
	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;
	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "doenerportal@gmail.com";
	//Password to use for SMTP authentication
	$mail->Password = "doener2017";
	//Set who the message is to be sent from
	$mail->setFrom('doenerportal@gmail.com', 'Doenerportal');
	//Set an alternative reply-to address
	$mail->addReplyTo('doenerportal@gmail.com', 'Doenerportal');
	//Set the subject line
	$mail->Subject = 'Dönnerportal - neues Passwort';


	//Set who the message is to be sent to
	$mail->addAddress($sendTo);

	$mail->msgHTML('
			<!DOCTYPE html>
			<style>
				*{
					text-align:center;
					font-family:Arial;
				}
			</style>
			<html>
			<head>
				<meta charset="utf-8" />
				<title>Neues Passwort für das Dönerportal</title>
			</head>
			<body>
				<h1>Neues Passwort</h1>
				<p>Herzlichen Glückwunsch!</p>
				<p>Da du verblödeter Idiot dein Passwort schon wieder vergssen hast, schicken wir dir ein neues.</p>
				<h2>'.$pw.'</h2>
				<p>speichere es endlich ab!</p>
				<p style="color:white;">Du Hurensohn!</p>
				<h4>Mit freundlichen Grüßen</h4>
				<h3>Dein Dönerportal des Vertrauens</h3>
			</body>
			</html>
		');
	$mail->AltBody = 'Irgendwas ist schief gelaufen';



	//send the message, check for errors
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Ihre Nachricht wurde gesendet";
		?><meta http-equiv="refresh" content="5; URL=index.php"><?php
		//Section 2: IMAP
		//Uncomment these to save your message in the 'Sent Mail' folder.
		#if (save_mail($mail)) {
		#    echo "Message saved!";
		#}
	}
}


function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

?>

<div class="">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" class="form-signin">
		<h1 class="h1 mb-3 font-weight-normal">Passwort Zur&uuml;cksetzen</h1>
		<input class="form-control" type="text" id="userMail" name="userMail" required placeholder="Bitte geben Sie ihre Mailadresse ein"></input>
		<button type="submit" class="btn btn-primary">Neues Passwort anfordern</button>
	</form>
</div>

<?php 
//import std Footer
require_once 'footer.php';
?>