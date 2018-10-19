<!--START head.php-->
<?php require_once 'config.php';?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="css/select2.min.css" rel="stylesheet" />
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/select2.min.js"></script>
	    <link  href="css/main.css" rel="stylesheet">
		<title>D&ouml;ner</title>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
	</head>
	<body class="text-center">
		<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="./kundenkonto.php">D&ouml;nerportal</a>
			<div class="navbar-nav">
				<?php if(isset($_SESSION['token'])&&isset($_SESSION['user'])): ?>
					<a class="nav-item nav-link active" href="./auftrag.php">Bestellen <span class="sr-only">(current)</span></a>
					<a class="nav-item nav-link" href="./changePW.php">Passwort &auml;ndern</a>
					<?php if($_SESSION['rolle']=='admin'): ?>
						<a class="nav-item nav-link" href="./zeigelleBestellungen.php">Bestellungen anzeigen</a>
						<a class="nav-item nav-link" href="./editUsers.php">User bearbeiten</a>
					<?php endif; ?>
					<a class="nav-item nav-link navbar-right" href="./logout.php">Logout</a>
				<?php else: ?>
					<a class="nav-item nav-link" href="./index.php">Login</a>
				<?php endif; ?>				
			</div>
		</nav>
<!--END head.php-->