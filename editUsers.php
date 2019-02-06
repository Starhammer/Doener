<?php
session_start();
include_once 'head.php';

$role = mysqli_fetch_row(query("SELECT Rolle FROM kunden WHERE kdnr='".$_SESSION['user']."'"))[0];
if($role != 'admin') header('Location: '.$base."\index.php");

$kdnr = $_GET['kdnr'];
if(isset($kdnr)&&!empty($kdnr)){
	$kdnr = mysqli_real_escape_string($link,$kdnr);
	$user= mysqli_fetch_array("SELECT * From kunden WHERE kdnr='".$kdnr."'");
	if($user['val']!='J'){
		query("UPDATE kunden SET val = 'J' WHERE kdnr='".$kdnr."'");
		mail($user['email'], "Validierung des Doener Portals", "Dein Account beim Döner Portal wurde validiert, fallst du dieses Portal nicht kennst ignoriere die Mail", "From: Doener Portal <doener@protal.de>");
	}
}

$users = query("SELECT * FROM kunden ORDER BY `kunden`.`kdnr` DESC");
?>

<!-- JS fuer das suchen in der Tabelle -->
 <script  src="js/searchTable.js"></script>

<header>
    <h1 class="h1 mb-3 font-weight-normal">Benutzer bearbeiten</h1>
</header>
<div id="main">
	<table class="table table-striped table-condensed" id="User_table">
	<input type="text" id="table_input" placeholder="Suche..." class="form-control input_table" onkeyup="searchTable()"></input>
		<thead>
			<tr>
				<th>KD.-Nr.</th>
				<th>Name</th>
				<th>Vorname</th>
				<th>vald.</th>
				<th>Kurs</th>
				<th>Nick</th>
				<th>Email</th>
				<th>Rolle</th>
				<th>Aktionen</th>
			</tr>
		</thead>		
		<?php while($row = mysqli_fetch_array($users)):?>
		<tr class="tr-content">
			<td class="table_KD"><?php echo ltrim($row['kdnr'],'0')?></td>
			<td class="table_name"><?php echo $row['name']?></td>
			<td class="table_vorname"><?php echo $row['vorname']?></td>
			<td class="table_val"><?php echo $row['val']?></td>
			<td class="table_kurs"><?php echo $row['kurs']?></td>
			<td class="table_nick"><?php echo $row['nick']?></td>
			<td class="table_email"><?php echo $row['email']?></td>
			<td class="table_rolle"><?php echo $row['Rolle']?></td>
			<td>
				<a class="btn btn-sm btn-outline-danger btn-felx" href="editUser.php?kdnr=<?php echo $row['kdnr'];?>">edit</a> 
				<?php if($row['val'] != "J"): ?>
					<a class="btn btn-sm btn-success btn-felx" href="<?php echo $_SERVER['PHP_SELF']."?kdnr=".$row['kdnr']; ?>">best&auml;tigen</a>
				<?php endif; ?>				
			</td>
		</tr>
		<?php endwhile;?>
	</table>
	<div class="container">
		<a class="btn btn-primary btn-flex" href="kundenkonto.php">Zurück</a>
	</div>
 </div>


<?php
include_once "footer.php";
?>