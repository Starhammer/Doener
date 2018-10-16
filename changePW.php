<!--START changePW.php-->
<?php require_once 'head.php';

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
<link href="css/signin.css" rel="stylesheet">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class="form-signin">
	<h1 class="h1 mb-3 font-weight-normal">Passwort &auml;ndern</h1>

	<p><?php echo  $msg;?></p>

	<nav class="p-3">
		<a href="<?php echo $base."/kundenkonto.php";?>">Zur&uuml;ck zum Kundenkonto</a>
	</nav>
		
	<label class="sr-only" for="old_pw">Aktuelles Passwort</label>
	<input class="form-control" id="old_pw" name="old_pw" type="password" placeholder="Aktuelles Passwort" required>
	<label class="sr-only" for="new_pw">Neues Passwort</label>
	<input class="form-control" id="new_pw" name="new_pw" type="password" placeholder="Neues Passwort" required>
	<label class="sr-only" for="new_confirmed_pw">Neues Passwort best&auml;tigen:</label>
	<input class="form-control" id="new_confirmed_pw" name="new_confirmed_pw" type="password" placeholder="Neues Passwort best&auml;tigen" required>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Passwort &auml;ndern</button>
</form>

<?php require_once 'footer.php';?>
<!--END changePW.php-->