<?php require_once 'head.php';
checkSession();
$role = mysqli_fetch_row(query("SELECT Rolle FROM kunden WHERE kdnr='".$_SESSION['user']."'"))[0];
?>
<header>
	<h1>Kundenkonto</h1>
</header>
<nav style="padding-top:3%">
<ul>
    <li><a href="<?php echo $base."/auftrag.php";?>">Bestellung aufgeben</a></li>
    <?php if($role=='admin'):?><li><a href="<?php echo $base."/zeigeAlleBestellungen.php";?>">zeige alle Bestellungen</a></li><?php endif;?>
     <li><a href="<?php echo $base."/changePW.php";?>">Passwort &auml;ndern</a></li>
     <li><a href="<?php echo $base."/logout.php";?>">Logout</a></li>
</ul>
</nav>


<?php require_once 'footer.php';?>