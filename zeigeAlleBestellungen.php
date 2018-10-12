<?php 
require_once 'head.php';
checkSession();
$role = mysqli_fetch_row(query("SELECT Rolle FROM kunden WHERE kdnr='".$_SESSION['user']."'"))[0];
if($role != 'admin') header('Location: '.$base."\index.php");


$tblBestellung =array();

$bestellungen = query("
Select  a.kdnr, a.aufnr, a.aufdat, b.posnr, b.prnr
from auftrag a, aufpos b
WHERE a.aufnr = b.aufnr
AND aufdat > ".date('Y-m-d',time()-60*60*24*2)."
ORDER BY  a.aufdat DESC
LIMIT 30
");//TODO DATE 

while($bestellung = mysqli_fetch_array($bestellungen)){
    $kundennr ="";
    for($i=0;$i<5-strlen($bestellung['kdnr']);$i++){
        $kundennr .= "0";
    }
    $kundennr .=$bestellung['kdnr'];
    $name = mysqli_fetch_array(query("SELECT name,vorname FROM kunden WHERE kdnr='".$kundennr."'"));
    $tblBestellung[$bestellung['posnr']]['kundenNr']=$name[0].", ".$name[1];
    $name = mysqli_fetch_array(query("SELECT bez FROM produkt WHERE prnr='".$bestellung['prnr']."'"));
    $tblBestellung[$bestellung['posnr']]['produkt']=$name[0];
    $tblBestellung[$bestellung['posnr']]['datum']=$bestellung['aufdat'];
}

// $tblBestellung[$bestellung['aufpos']]['preis']=$bestellung['aufpos'];
// $tblBestellung[$bestellung['aufpos']]['name']=;

$zutaten = query("
Select c.kdnr Kunde, c.aufnr auftragsnummer, d.zunr zutatennummer,c.posnr
from (	Select  a.kdnr, a.aufnr, a.aufdat, b.posnr, b.prnr
		from auftrag a, aufpos b
		WHERE a.aufnr = b.aufnr
        AND aufdat > ".date('Y-m-d',time()-60*60*24*2).") c,
		zutbest d
Where c.posnr = d.posnr
"); //TODO DATE
while($zutat = mysqli_fetch_array($zutaten)){
    $name = mysqli_fetch_array(query("SELECT bez FROM zutaten WHERE zunr='".$zutat['zutatennummer']."'"));
    $tblBestellung[$zutat['posnr']]['zutaten'].=$name[0]." ";
}

$preise = query("
Select c.kdnr, c.aufnr, d.prnr, d.vk,c.posnr
from (	Select  a.kdnr, a.aufnr, a.aufdat, b.posnr, b.prnr
		from auftrag a, aufpos b
		WHERE a.aufnr = b.aufnr
        AND aufdat > ".date('Y-m-d',time()-60*60*24*2).") c,
		produkt d
Where c.prnr = d.prnr
Order by c.aufnr
");
while($preis = mysqli_fetch_array($preise)){
    $tblBestellung[$preis['posnr']]['preis']=$preis['vk'];
}

$aufpreise = query("
Select sum(g.aup), g.kdnr, g.posnr
from ( Select e.kdnr, e.aufnr, e.posnr, f.aup 
       from( 	Select c.kdnr, c.aufnr, c.posnr, d.zunr 
	        	from (	Select  a.kdnr, a.aufnr, a.aufdat, b.posnr, b.prnr
		        		from auftrag a, aufpos b
		       			WHERE a.aufnr = b.aufnr
                        AND aufdat > ".date('Y-m-d',time()-60*60*24*2).") c,
	        	zutbest d
	        	Where c.posnr = d.posnr ) e,
    			zutaten f
     	Where f.zunr = e.zunr
     	Order by aufnr) g
group by g.kdnr, g.posnr
");
while($aufpreis = mysqli_fetch_array($aufpreise)){
    $tblBestellung[$aufpreis['posnr']]['preis']+=$aufpreis['sum(g.aup)'];
}
?>
<body>
    <header>
    	<h1>Bestellungen anzeigen</h1>
    </header>
    <div id="main">
    	<table class="table table-striped table-condensed">
			<thead>
    			<tr>
					<th>Nr</th>
					<th>Name</th>
					<th>produkt</th>
					<th>zutaten</th>
					<th>Preis</th>
					<th>Datum</th>
				</tr>
			</thead>
    		<?php $i = 1;
    		foreach($tblBestellung as $bestellung):?>
    			<tr>
					<td><?php echo $i++?></td>
					<td><?php echo $bestellung['kundenNr']?></td>
					<td><?php echo $bestellung['produkt']?></td>
    				<td><?php echo $bestellung['zutaten']?></td>
					<td><?php echo number_format ($bestellung['preis'],2)?></td>
					<td><?php echo date("d.m.Y",strtotime($bestellung['datum']))?></td>
				<tr>
    		<?php endforeach;?>
    	</table>
    	<a class="btn btn-primary" role="button" href="<?php echo $base."/kundenkonto.php";?>">Zur&uuml;ck</a>
    </div>
</body>

<?php require_once 'footer.php';?>