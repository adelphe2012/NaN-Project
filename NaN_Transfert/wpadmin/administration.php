<?php

session_start();


if ($_SESSION['username']) {

require "../database.php";

function retSold($value){
	$db = Database::connect();
	$stmt = $db->query("SELECT * FROM admin ");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	Database::disconnect();
	$Solde = 0;
	for ($i=0; $i < sizeof($data) ; $i++) { 
		if ($data[$i]["username"] === $value) {
			$Solde = $data[$i]["compte_acn"];
			break;
		}
	}
	return $Solde;
}

$_SESSION['compte_acn'] = retSold($_SESSION['username']);

?>		


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script src="../js/code.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/material-bootstrap-wizard.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<title>ACN | Transactions</title>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand text-center" href="#">
		    Bienvenue <br>
		    <small><b><?php echo $_SESSION['username']; ?></b></small>
		  </a>
		  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav ml-auto">
		    	<li class="nav-link">
	  				<a class="text-dark" href="administration.php">accueil</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="listuser.php">utilisateurs</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="transaction.php">voir les transactions</a>
	  			</li>
	  			<li class="nav-link">
	  				<a class="text-dark" href="bonus.php">faire des bonus</a>
	  			</li>
		    </ul>
		    <div class="ml-auto">
	  			<a class="btn btn-outline-dark" href="../member/logout.php"><span class="fa fa-sign-out"></span></a>
		    </div>
		  </div>
		</nav>

	</header>
	<div class="image-container set-full-height" style="background: url(../img/admin_img.jpg) top center; height: auto; overflow: hidden;">
		
		
		<div class="container-fluid">
		  <div class="col-sm-12">
		    <div class="card_member">
		    	<div class="card col-sm-4 offset-md-4">
			      <div class="card-body text-center ">
			        <h5 class="card-title">Soldes Admin</h5>
			        <p class="card-text"><b><?php echo $_SESSION['compte_acn']; ?></b> FCFA</p>
			      </div>
			    </div>
		    </div>
		  </div>

		</div>



		<footer class="text-center text-light">
			<p>
				<b>ACN</b> | <b>Transfert d'Argernt</b> Copyright 2019
			</p>
		</footer>
	</div>



</body>
</html>

<?php 

}else{
	header("location:../404/index.php");
}


 ?>