<?php
session_start();
require_once 'head.php'; 

$auftrag_produkt = $_POST['product'];
$auftrag_ingredients = $_POST['Ingredients'];

$orderPlaced = false;
if(isset($auftrag_produkt)){
    
//     print_r($auftrag_produkt);
//     print_r($auftrag_ingredients);
    
    //Datums fehler noch
//     echo date("Y-m-d",time());
//     die;
    query("INSERT INTO auftrag (kdnr,aufdat) VALUES (".$_SESSION['user'].",'".date("Y-m-d",time())."')");
    
    $aufnr = mysqli_fetch_array(query('SELECT * FROM auftrag ORDER BY aufnr DESC LIMIT 1'))['aufnr'];
    query('INSERT INTO aufpos (prnr,aufnr) VALUES ('.$auftrag_produkt.','.$aufnr.')');
    
    if(isset($auftrag_ingredients)){
        $posnr = mysqli_fetch_array(query('SELECT * FROM aufpos ORDER BY posnr DESC LIMIT 1'))['posnr'];
        foreach ($auftrag_ingredients as $ingredient){
            query('INSERT INTO zutbest (posnr,zunr) VALUES('.$posnr.','.$ingredient.')');
        }
    }
    
    //Belasten des Kundenkontos
    $preis = mysqli_fetch_array(query("SELECT * FROM produkt WHERE prnr='".$auftrag_produkt."'"))['VK'];
    
    if(isset($auftrag_ingredients)){
        foreach ($auftrag_ingredients as $ingredient){
            $preis +=  mysqli_fetch_array(query("SELECT * FROM zutaten WHERE zunr='".$ingredient."'"))['aup'];
        }
    }
    $konto = 
    query("UPDATE kunden SET konto = konto - ".$preis." WHERE kdnr='".$_SESSION['user']."'");
    $orderPlaced = true;
}
?>
<body>
<header>
	<h1 class="h1 mb-3 font-weight-normal">Bestellung aufgeben</h1>
</header>
<?php if($orderPlaced):?>

<p>Bestellung wurde gespeichert</p>
<?php echo "Der Preis beträgt ".$preis." Euro </br>";?>
<a href="<?php echo $base."/kundenkonto.php";?>">Zur&uuml;ck zum Kundenkonto</a>

<?php else: 
$produkte =array();
$jsingredients = array();
?>
<!--div style="padding-left: 1%">
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    	<select id="product" name="product" style="width:150px">
            <?php // Select all from Product
            $products = query("Select * FROM produkt");
            while($product = mysqli_fetch_array($products)):?>
            		<?php $produkte[$product['prnr']] = $product['VK']?>
            	<option  value="<?php echo $product['prnr'];?>"><?php echo $product['bez'];?></option>
            <?php endwhile;?>
        </select>
        <?php echo "mit";?>
        <select id="ingredients" multiple name="ingredients[]" style="width:150px" class="col-md4">
        	 <?php // Select all from zutaten
            $ingredients = query("Select * FROM zutaten");
            while($ingredient = mysqli_fetch_array($ingredients)):
				  $jsingredients[$ingredient['zunr']] = $ingredient['aup']?>
            	<option value="<?php echo $ingredient['zunr'];?>"><?php echo $ingredient['bez'];?></option>
            <?php endwhile;?>
        </select>
        <button class="btn btn-primary" type="submit">Bestellung absenden</button>
	</form>
	
	<span>Der Preis beträgt: </span>
	<span id="preis"><?php echo "";?></span>
	<span> Euro <br></span>
	<br>
	<a class="btn btn-primary" role="button" href="<?php echo $base."/kundenkonto.php";?>">Zur&uuml;ck zum Kundenkonto</a>
</div-->


<!-- Test -->
<div class="justify-content-md-center">
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<div class="row justify-content-center pt-4 pb-4 mr-0 ml-0">
			<div class="col-sm-1">
    			<select id="product" name="product" class="form-control">
					<?php // Select all from Product
					$products = query("Select * FROM produkt");
					while($product = mysqli_fetch_array($products)):?>
            				<?php $produkte[$product['prnr']] = $product['VK']?>
            			<option  value="<?php echo $product['prnr'];?>"><?php echo $product['bez'];?></option>
					<?php endwhile;?>
				</select>
			</div>
			<?php echo "mit";?>
			<div id="meat_ingredients" class="col-md-1 form-check text-left border-right border-primary">
				<fiealdset>
				<?php // Select meat from zutaten
					$ingredients = query("Select * FROM zutaten WHERE kategorie = 0");
					while($ingredient = mysqli_fetch_array($ingredients)):
						  $jsingredients[$ingredient['zunr']] = $ingredient['aup']?>
            			<div class="form-check ingredients">
            				<input class="form-check-input" required type="radio" name="Ingredients[]" value="<?php echo $ingredient['zunr'];?>"></input>
							<label class="form-check-label" for="<?php echo $ingredient['bez'];?>"><?php echo $ingredient['bez'];?></label>
						</div>
				<?php endwhile;?>
				</fieldset>
			</div>
			<div id="vegetable_ingredients" class="col-md-1 form-check text-left border-left border-right border-primary">
				<?php // Select vegetable from zutaten
					$ingredients = query("Select * FROM zutaten WHERE kategorie = 1");
					while($ingredient = mysqli_fetch_array($ingredients)):
						  $jsingredients[$ingredient['zunr']] = $ingredient['aup']?>
            			<div class="form-check ingredients">
            				<input class="form-check-input" type="checkbox" name="Ingredients[]" value="<?php echo $ingredient['zunr'];?>"></input>
							<label class="form-check-label" for="<?php echo $ingredient['bez'];?>"><?php echo $ingredient['bez'];?></label>
						</div>
				<?php endwhile;?>
			</div>
			<div id="extra_ingredients" class="col-md-1 form-check text-left border-left border-primary">
				<?php // Select extras from zutaten
					$ingredients = query("Select * FROM zutaten WHERE kategorie = 2");
					while($ingredient = mysqli_fetch_array($ingredients)):
						  $jsingredients[$ingredient['zunr']] = $ingredient['aup']?>
            			<div class="form-check ingredients">
            				<input class="form-check-input" type="checkbox" name="Ingredients[]" value="<?php echo $ingredient['zunr'];?>"></input>
							<label class="form-check-label" for="<?php echo $ingredient['bez'];?>"><?php echo $ingredient['bez'];?></label>
						</div>
				<?php endwhile;?>
			</div>
		</div>

        <button class="btn btn-primary" type="submit">Bestellung absenden</button>
	</form>
	
	<span>Der Preis beträgt: </span>
	<span id="preis"><?php echo "";?></span>
	<span> Euro <br></span>
	<br>
	<a class="btn btn-primary" role="button" href="<?php echo $base."/kundenkonto.php";?>">Zur&uuml;ck zum Kundenkonto</a>



</body>

<?php endif;?>

<?php require_once 'footer.php';?>

<script text="text/javascript">

//On Change from select preis neu Bewerten
var produkte = <?php echo json_encode($produkte); ?>;
var ingredients = <?php echo json_encode($jsingredients); ?>;

function updatePrice(){
	var preis = parseFloat( produkte[$('#product').children(":selected").val()] );
	$.each($('.ingredients').children("input:checked"), function(){	
		preis = preis + parseFloat( ingredients[$(this).val()] );
	});
	$('#preis').text(preis.toFixed(2));
}



$( document ).ready(function() {
	$('select').trigger("change");
});

$(':checkbox').change(function(){
	updatePrice();
});
$('select').change(function(){
	updatePrice();
});

</script>