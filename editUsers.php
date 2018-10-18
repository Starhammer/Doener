<?php
session_start();
include_once 'head.php';

$role = mysqli_fetch_row(query("SELECT Rolle FROM kunden WHERE kdnr='".$_SESSION['user']."'"))[0];
if($role != 'admin') header('Location: '.$base."\index.php");

$kdnr = $_GET['kdnr'];
if(isset($kdnr)&&!empty($kdnr)){
	$kdnr = mysqli_real_escape_string($link,$kdnr);
	query("UPDATE kunden SET val = 'J' WHERE kdnr='".$kdnr."'");
	$user= mysqli_fetch_array("SELECT * From kunden WHERE kdnr='".$kdnr."'");
	mail($user['email'], "Validierung des Doener Portals", "Dein Account beim Döner Portal wurde validiert, fallst du dieses Portal nicht kennst ignoriere die Mail", "From: Doener Portal <doener@protal.de>");
}

$users = query("SELECT * FROM kunden ORDER BY `kunden`.`kdnr` DESC");
?>

<table class="table table-striped table-condensed">
<tr><th>kdnr</th><th>name</th><th>vorname</th><th>val</th><th>kurs</th><th>nick</th><th>email</th><th>Rolle</th><th>Aktionen</th></tr>
<?php while($row = mysqli_fetch_array($users)):?>
<tr><td><?php echo ltrim($row['kdnr'],'0')?></td><td><?php echo $row['name']?></td><td><?php echo $row['vorname']?></td><td><?php echo $row['val']?></td>
<td><?php echo $row['kurs']?></td><td><?php echo $row['nick']?></td><td><?php echo $row['email']?></td><td><?php echo $row['Rolle']?></td>
<td><a href="editUser.php?kdnr=<?php echo $row['kdnr'];?>">edit</a> <a href="<?php echo $_SERVER['PHP_SELF']."?kdnr=".$row['kdnr']; ?>">best&auml;tigen</a></td></tr>
<?php endwhile;?>
</table>
 <a class="btn btn-lg btn-primary btn-block" href="kundenkonto.php">Zurück</a>
<?php
include_once "footer.php";
?>