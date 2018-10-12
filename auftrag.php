<?php require_once 'head.php'; 
checkSession();

$auftrag_produkt = $_POST['product'];
$auftrag_ingredients = $_POST['ingredients'];

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
	<h1>auftrag</h1>
</header>
<?php if($orderPlaced):?>

<p>Bestellung wurde gespeichert</p>
<?php echo "Der Preis beträgt ".$preis." Euro </br>";?>
<a href="<?php echo $base."/kundenkonto.php";?>">Zur&uuml;ck zum Kundenkonto</a>

<?php else: 
$produkte =array();
$jsingredients = array();
?>
<div style="padding-left: 1%">
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
        <select id="ingredients" multiple name="ingredients[]" style="width:150px">
        	 <?php // Select all from zutaten
            $ingredients = query("Select * FROM zutaten");
            while($ingredient = mysqli_fetch_array($ingredients)):?>
            <?php $jsingredients[$ingredient['zunr']] = $ingredient['aup']?>
            	<option value="<?php echo $ingredient['zunr'];?>"><?php echo $ingredient['bez'];?></option>
            <?php endwhile;?>
        </select>
        <button type="submit">Bestellung absenden</button>
	</form>
	
	<span>Der Preis beträgt: </span>
	<span id="preis"><?php echo "";?></span>
	<span> Euro <br></span>
	
	<a href="<?php echo $base."/kundenkonto.php";?>">Zur&uuml;ck zum Kundenkonto</a>
</div>
</body>

<?php endif;?>

<?php require_once 'footer.php';?>
<script text="text/javascript">
$('select').select2({
	  allowClear: true
	});

//On Change from select preis neu Bewerten
var produkte = <?php echo json_encode($produkte); ?>;
var ingredients = <?php echo json_encode($jsingredients); ?>;

$( document ).ready(function() {
	$('select').trigger("change");
});


$('select').change(function(){
	var preis = produkte[$('#product').children(":selected").val()];

	var selectedIngredients = [];
	$.each($('#ingredients').children(":selected"), function(){
	var selectedId = $(this).val();
		$.each(ingredients,function(index,value){
			if(index==selectedId)preis= +preis + +value;
		});
// 		selectedIngredients.push($(this).val());
	});
	
	
// 	var productpreis = $('#product').children(":selected").attr("id");
// 	var ingredientspreis = $('#ingredients').children(":selected").attr("id");
// 	alert(ingredientspreis);
	$('#preis').text(preis);
});
</script>