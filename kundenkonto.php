<!--START kundenkonto.php-->
<?php require_once 'head.php';
$role = mysqli_fetch_row(query("SELECT Rolle FROM kunden WHERE kdnr='".$_SESSION['user']."'"))[0];
?>
<header>
	<h1 class="h1 mb-3 font-weight-normal">Kundenkonto</h1>
</header>
<div class="container p-4">
	<div class="row">
        <div class="container">
          <a class="btn btn-primary btn-block" role="button" href="<?php echo $base."/auftrag.php";?>">Bestellung aufgeben</a>
		  <?php if($role=='admin'):?><a class="btn btn-primary btn-block" role="button" href="<?php echo $base."/zeigeAlleBestellungen.php";?>">zeige alle Bestellungen</a><?php endif;?>
          <a class="btn btn-primary btn-block" role="button" href="<?php echo $base."/changePW.php";?>">Passwort &auml;ndern</a>
		  <a class="btn btn-primary btn-block" role="button" href="<?php echo $base."/logout.php";?>">Logout</a>
        </div>
    </div>
</div>



<?php require_once 'footer.php';?>
<!--END kundenkonto.php-->